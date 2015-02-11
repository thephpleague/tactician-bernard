<?php

namespace League\Tactician\Bernard\Listener;

use League\Event\EventInterface;
use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;
use League\Tactician\Bernard\Event\ConsumerCycle;

/**
 * Stops the consumer when it reaches the time limit
 */
class TimeLimit implements ListenerProviderInterface
{
    /**
     * @var integer
     */
    protected $timeLimit;

    /**
     * @var boolean
     */
    protected $initialized = false;

    /**
     * @param integer $timeLimit
     */
    public function __construct($timeLimit)
    {
        $this->timeLimit = $timeLimit;
    }

    /**
     * {@inheritdoc}
     */
    public function provideListeners(ListenerAcceptorInterface $listenerAcceptor)
    {
        $listenerAcceptor->addListener('consumerCycle', [$this, 'check']);
    }

    /**
     * Check if the consumer passed the limit
     *
     * @param ConsumerCycle $event
     */
    public function check(ConsumerCycle $event)
    {
        if (!$this->initialized) {
            $this->timeLimit += microtime(true);

            $this->initialized = true;
        }

        if ($this->timeLimit < microtime(true)) {
            $event->stopConsumer();
        }
    }
}
