<?php

namespace League\Tactician\Bernard\Listener;

use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;
use League\Tactician\Bernard\Consumer;
use League\Tactician\CommandEvents\Event\CommandEvent;

/**
 * Stops the consumer when it reaches the time limit
 */
class TimeLimit implements ListenerProviderInterface
{
    /**
     * @var Consumer
     */
    protected $consumer;

    /**
     * @var integer
     */
    protected $timeLimit;

    /**
     * @var boolean
     */
    protected $initialized = false;

    /**
     * @param Consumer $consumer
     * @param integer  $timeLimit
     */
    public function __construct(Consumer $consumer, $timeLimit)
    {
        $this->consumer = $consumer;
        $this->timeLimit = $timeLimit;
    }

    /**
     * {@inheritdoc}
     */
    public function provideListeners(ListenerAcceptorInterface $listenerAcceptor)
    {
        $listenerAcceptor->addListener('commandExecuted', [$this, 'handle']);
        $listenerAcceptor->addListener('commandFailed', [$this, 'handle']);
    }

    /**
     * Check if the consumer passed the limit
     *
     * @param CommandEvent $event
     */
    public function handle(CommandEvent $event)
    {
        if (!$this->initialized) {
            $this->timeLimit += microtime(true);

            $this->initialized = true;
        }

        if ($this->timeLimit < microtime(true)) {
            $this->consumer->shutdown();
        }
    }
}
