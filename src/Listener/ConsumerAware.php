<?php

namespace League\Tactician\Bernard\Listener;

use League\Event\ListenerProviderInterface;
use League\Tactician\Bernard\Consumer;

/**
 * Consumer container
 */
abstract class ConsumerAware implements ListenerProviderInterface
{
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
     * Sets the consumer
     *
     * @param Consumer $consumer
     */
    public function setConsumer(Consumer $consumer)
    {
        $this->consumer = $consumer;
    }

    /**
     * Stops the consumer
     */
    protected function stopConsumer()
    {
        if (!isset($this->consumer)) {
            throw new \RuntimeException('Consumer not found');
        }

        $this->consumer->shutdown();
    }
}
