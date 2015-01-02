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
    use \League\Event\EmitterTrait;

    /**
     * While this is true the loop will continue running
     *
     * @var boolean
     */
    protected $run = true;

    /**
     * Starts an infinite loop
     *
     * @param Queue      $queue
     * @param CommandBus $commandBus
     */
    public function consume(Queue $queue, CommandBus $commandBus)
    {
        $this->bind();

        $this->emit('consumerStarted');
        $consumerCycleEvent = new Event\ConsumerCycle($this);

        while ($this->run) {
            try {
                $this->doConsume($queue, $commandBus);
            } catch (Exception\StopConsumer $e) {
                break;
            }

            $this->emit($consumerCycleEvent);
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

        $command = $this->getCommandFor($envelope);

        try {
            $commandBus->execute($command);
            $queue->acknowledge($envelope);
        } catch (Exception\CommandFailed $e) {
            $this->emit('commandFailed', $e);
        } catch (\Exception $e) {
            $this->emit('commandErrored', $e);
        }

        $this->emit('commandExecuted');
    }

    /**
     * Returns the command from the envelope
     *
     * @param Envelope $envelope
     *
     * @return object
     */
    protected function getCommandFrom(Envelope $envelope)
    {
        $command = $envelope->getMessage();

        if ($command instanceof CommandMessage) {
            $command = $command->getCommand();
        }

        return $command;
    }

    /**
     * Set limits to an invalid value to shut down on the next cycle
     */
    public function shutdown()
    {
        $this->run = false;
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
