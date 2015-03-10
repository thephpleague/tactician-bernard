<?php

namespace League\Tactician\Bernard;

use Bernard\Message;
use Bernard\Producer;
use League\Tactician\Command;
use League\Tactician\Middleware;

/**
 * Sends the command to a remote location using message queues
 */
class QueueMiddleware implements Middleware
{
    /**
     * @var Producer
     */
    protected $producer;

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
    public function execute(Command $command, callable $next)
    {
        if ($command instanceof Message) {
            $this->producer->produce($command);

            return;
        }

        return $next($command);
    }
}
