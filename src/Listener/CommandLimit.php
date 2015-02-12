<?php

namespace League\Tactician\Bernard\Listener;

use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;
use League\Tactician\Bernard\Consumer;
use League\Tactician\CommandEvents\Event\CommandEvent;

/**
 * Stops the consumer when it reaches the command limit
 */
class CommandLimit implements ListenerProviderInterface
{
    /**
     * @var Consumer
     */
    protected $consumer;

    /**
     * @var integer
     */
    protected $commandLimit;

    /**
     * @var integer
     */
    protected $commandCount = 0;

    /**
     * @var boolean
     */
    protected $countFailures = true;

    /**
     * @param Consumer $consumer
     * @param integer  $commandLimit
     * @param boolean  $countFailures
     */
    public function __construct(Consumer $consumer, $commandLimit, $countFailures = true)
    {
        $this->consumer = $consumer;
        $this->commandLimit = $commandLimit;
        $this->countFailures = (bool) $countFailures;
    }

    /**
     * {@inheritdoc}
     */
    public function provideListeners(ListenerAcceptorInterface $listenerAcceptor)
    {
        $listenerAcceptor->addListener('commandExecuted', [$this, 'handle']);

        // Count failed commands as well
        if ($this->countFailures) {
            $listenerAcceptor->addListener('commandFailed', [$this, 'handle']);
        }
    }

    /**
     * Check if the consumer passed the limit
     *
     * @param CommandEvent $event
     */
    public function handle(CommandEvent $event)
    {
        $this->commandCount++;

        if ($this->commandLimit <= $this->commandCount) {
            $this->consumer->shutdown();
        }
    }
}
