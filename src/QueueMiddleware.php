<?php

namespace League\Tactician\Bernard;

use Bernard\Envelope;
use Bernard\Message;
use Bernard\Queue;
use League\Tactician\Command;
use League\Tactician\Middleware;

/**
 * Sends the command to a remote location using message queues
 */
class QueueMiddleware implements Middleware
{
    /**
     * @var Queue
     */
    protected $queue;

    /**
     * @param Queue $queue
     */
    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(Command $command, callable $next)
    {
        if (!$command instanceof QueueableCommand) {
            $command = new CommandWrapper($command);
        }

        if ($command->shouldBeQueued()) {
            $this->queue->enqueue(new Envelope($command));
            return;
        }

        if ($command instanceof CommandWrapper) {
            $command = $command->getCommand();
        }

        return $next($command);
    }
}
