<?php

namespace League\Tactician\Bernard\Listener;

use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;
use League\Tactician\CommandEvents\CommandEvent;

/**
 * Add a wait time to the consumer to slow down the infinite loop
 */
class Wait implements ListenerProviderInterface
{
    /**
     * @var integer
     */
    protected $wait;

    /**
     * @var boolean
     */
    protected $microSeconds = false;

    /**
     * @param integer $wait
     * @param boolean $microSeconds
     */
    public function __construct($wait, $microSeconds = false)
    {
        $this->wait = $wait;
        $this->microSeconds = (bool) $microSeconds;
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
     * Wait for the given time
     *
     * @param CommandEvent $event
     */
    public function wait(CommandEvent $event)
    {
        if ($this->microSeconds) {
            usleep($this->wait);

            return;
        }

        sleep($this->wait);
    }
}
