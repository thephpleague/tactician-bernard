<?php

namespace League\Tactician\Bernard;

use Bernard\Message;
use Bernard\Producer;
use League\Tactician\Command;
use League\Tactician\Middleware;

/**
 * Sends the command to a remote location using message queues
 */
final class QueueMiddleware implements Middleware
{
    /**
     * @var Producer
     */
    private $producer;

    /**
     * @param Producer $producer
     */
    public function __construct(Producer $producer)
    {
        $this->producer = $producer;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if ($command instanceof QueueableCommand) {
            $this->producer->produce($command, $command->getQueueName());
        }

        if ($command instanceof Message) {
            $this->producer->produce($command);

            return;
        }

        if ($command instanceof QueuedCommand) {
            $command = $command->getCommand();

            if ($command instanceof QueueCommand) {
                $command = $command->getCommand();
            }
        }

        return $next($command);
    }
}
