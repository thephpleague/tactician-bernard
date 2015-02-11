<?php

/*
 * This file is part of the Tactician Bernard Queueing package.
 *
 * (c) Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Tactician\Bernard;

use Bernard\Envelope;
use Bernard\Message;
use Bernard\Queue;
use League\Tactician\Command;
use League\Tactician\Middleware;

/**
 * Sends the command to a remote location using message queues
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
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
        if ($command instanceof Message) {
            $this->queue->enqueue(new Envelope($command));

            return;
        }

        return $next($command);
    }
}
