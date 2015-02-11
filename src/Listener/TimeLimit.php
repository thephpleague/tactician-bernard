<?php

namespace League\Tactician\Bernard\Listener;

use League\Event\ListenerAcceptorInterface;
use League\Tactician\CommandEvents\CommandEvent;

/**
 * Stops the consumer when it reaches the time limit
 */
class TimeLimit extends ConsumerAware
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
            $this->stopConsumer();
        }
    }
}
