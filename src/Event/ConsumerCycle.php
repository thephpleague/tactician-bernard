<?php

namespace League\Tactician\Bernard\Event;

use League\Event\Event;
use League\Tactician\Bernard\Consumer;

/**
 * Emitted at the end of every cycle of consumer
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
