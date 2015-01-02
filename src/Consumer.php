<?php

/*
 * This file is part of the Indigo Doris package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Doris;

use Bernard\Queue;
use Tactician\CommandBus\CommandBus;

declare(ticks=1);

/**
 * Consume commands from a queue and execute them
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Consumer
{
    /**
     * @var integer|null
     */
    protected $messageLimit;

    /**
     * @var integer
     */
    protected $messageCount;

    /**
     * @var numeric
     */
    protected $runtimeLimit;

    /**
     * @param numeric      $runtimeLimit
     * @param integer|null $messageLimit
     */
    public function __construct($messageLimit = null, $runtimeLimit = PHP_INT_MAX)
    {
        $this->messageLimit = $messageLimit;
        $this->runtimeLimit = $runtimeLimit;
    }

    /**
     * Starts an infinite loop
     *
     * @param Queue      $queue
     * @param CommandBus $commandBus
     */
    public function consume(Queue $queue, CommandBus $commandBus)
    {
        $this->bind();

        // Start measuring time
        $this->runtimeLimit += microtime(true);

        while (true) {
            try {
                $this->check();
                $this->doConsume($queue, $commandBus);
            } catch (Exception\StopConsumer $e) {
                break;
            }
        }
    }

    /**
     * Does the actual consuming
     *
     * @param Queue      $queue
     * @param CommandBus $commandBus
     */
    protected function doConsume(Queue $queue, CommandBus $commandBus)
    {
        if (!$envelope = $queue->dequeue()) {
            return;
        }

        $command = $envelope->getMessage();

        if ($command instanceof CommandMessage) {
            $command = $command->getCommand();
        }

        try {
            $commandBus->execute($command);
            $queue->acknowledge($envelope);

            $this->messageCount++;
        } catch (Exception\CommandFailed $e) {
            // handle command failed
        } catch (\Exception $e) {
            // handle command errored
        }
    }

    /**
     * Checks whether the consumer should run
     */
    protected function check()
    {
        if (is_null($this->messageLimit) or $this->messageLimit < $this->messageCount) {
            return;
        }

        if (microtime(true) <= $this->runtimeLimit) {
            return;
        }

        throw new Exception\StopConsumer();
    }

    /**
     * Set limits to an invalid value to shut down on the next cycle
     */
    public function shutdown()
    {
        $this->runtimeLimit = $this->messageLimit = -1;
    }

    /**
     * Setup signal handlers for unix signals.
     */
    protected function bind()
    {
        pcntl_signal(SIGTERM, [$this, 'shutdown']);
        pcntl_signal(SIGQUIT, [$this, 'shutdown']);
        pcntl_signal(SIGINT,  [$this, 'shutdown']);
    }
}
