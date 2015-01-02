<?php

/*
 * This file is part of the Indigo Doris package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Doris\Event;

use Doris\Consumer;
use League\Event\Event;

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
