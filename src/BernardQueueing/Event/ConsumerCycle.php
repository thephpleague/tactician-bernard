<?php

/*
 * This file is part of the Tactician Bernard Queueing package.
 *
 * (c) Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Tactician\BernardQueueing\Event;

use League\Event\Event;
use League\Tactician\BernardQueueing\Consumer;

/**
 * Emitted at the end of every cycle of consumer
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ConsumerCycle extends Event
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'consumerCycle';

    /**
     * @var Consumer
     */
    protected $consumer;

    /**
     * @param Consumer $consumer
     */
    public function __construct(Consumer $consumer)
    {
        $this->consumer = $consumer;
    }

    /**
     * Stops the consumer
     */
    public function stopConsumer()
    {
        $this->consumer->shutdown();
    }
}
