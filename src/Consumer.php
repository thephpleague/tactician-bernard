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

            // TODO: some verification that a Command instance is returned

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
