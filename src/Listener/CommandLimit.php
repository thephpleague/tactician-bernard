<?php

/*
 * This file is part of the Tactician Bernard Queueing package.
 *
 * (c) Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Tactician\Bernard\Listener;

use League\Event\EventInterface;
use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;
use League\Tactician\Bernard\Event\ConsumerCycle;

/**
 * Stops the consumer when it reaches the command limit
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class CommandLimit implements ListenerProviderInterface
{
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
     * @param integer $commandLimit
     * @param boolean $countFailures
     */
    public function __construct($commandLimit, $countFailures = true)
    {
        $this->commandLimit = $commandLimit;
        $this->countFailures = (bool) $countFailures;
    }

    /**
     * {@inheritdoc}
     */
    public function provideListeners(ListenerAcceptorInterface $listenerAcceptor)
    {
        $listenerAcceptor->addListener('consumerCycle', [$this, 'check']);
        $listenerAcceptor->addListener('commandExecuted', [$this, 'count']);

        // Count failed commands as well
        if ($this->countFailures) {
            $listenerAcceptor->addListener('commandFailed', [$this, 'count']);
        }
    }

    /**
     * Check if the consumer passed the limit
     *
     * @param ConsumerCycle $event
     */
    public function check(ConsumerCycle $event)
    {
        if ($this->commandLimit <= $this->commandCount) {
            $event->stopConsumer();
        }
    }

    /**
     * Counts a command
     *
     * @param EventInterface $event
     */
    public function count(EventInterface $event)
    {
        $this->commandCount++;
    }
}
