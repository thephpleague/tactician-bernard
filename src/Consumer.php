<?php

namespace League\Tactician\Bernard;

use Bernard\Queue;
use League\Tactician\CommandBus;

/**
 * Consume commands from a queue and execute them
 */
class Consumer
{
    /**
     * While this is true the loop will continue running
     *
     * @var boolean
     */
    protected $consume = true;

    /**
     * Starts an infinite loop
     *
     * @param Queue      $queue
     * @param CommandBus $commandBus
     */
    public function consume(Queue $queue, CommandBus $commandBus)
    {
        while ($this->consume) {
            if ($envelope = $queue->dequeue()) {
                $command = $envelope->getMessage();

                // TODO: some verification that a Command instance is returned

                $commandBus->handle($command);
                $queue->acknowledge($envelope);
            }
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
