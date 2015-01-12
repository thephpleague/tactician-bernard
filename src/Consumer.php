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
use League\Tactician\CommandBus\CommandBus;

/**
 * Consume commands from a queue and execute them
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Consumer
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * While this is true the loop will continue running
     *
     * @var boolean
     */
    protected $consume = true;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Starts an infinite loop
     *
     * @param Queue $queue
     */
    public function consume(Queue $queue)
    {
        while ($this->consume) {
            $this->doConsume($queue);
        }
    }

    /**
     * Does the actual consuming logic separated from the loop
     *
     * @param Queue $queue
     */
    protected function doConsume(Queue $queue)
    {
        if ($envelope = $queue->dequeue()) {
            $command = $envelope->getMessage();

            if ($command instanceof CommandProxy) {
                $command = $command->getCommand();
            }

            $this->commandBus->execute($command);
            $queue->acknowledge($envelope);
        }
    }

    /**
     * Shutdown consumer on the next cycle
     */
    public function shutdown()
    {
        $this->consume = false;
    }
}
