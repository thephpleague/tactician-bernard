<?php

namespace League\Tactician\Bernard;

use Bernard\Message;
use League\Tactician\Middleware;

/**
 * Makes all commands queueable (except the ones that already come from a queue to prevent loops).
 *
 * Should be placed before {@link League\Tactician\Bernard\QueueMiddleware} in the middleware chain.
 */
class QueueAllMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if (!$command instanceof Message && !$command instanceof QueuedCommand) {
            $command = new QueueCommand($command);
        }

        return $next($command);
    }
}
