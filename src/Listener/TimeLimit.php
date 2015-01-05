<?php

/*
 * This file is part of the Indigo Doris package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Doris\Listener;

use Doris\Event\ConsumerCycle;
use League\Event\ListenerProviderInterface;
use League\Event\ListenerAcceptorInterface;
use League\Event\EventInterface;

/**
 * Stops the consumer when it reaches the time limit
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class TimeLimit implements ListenerProviderInterface
{
    /**
     * @var integer
     */
    protected $timeLimit;

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
        $listenerAcceptor->addListener('consumerStarted', [$this, 'initializeLimitValue']);
        $listenerAcceptor->addListener('consumerCycle', [$this, 'check']);
    }

    /**
     * Increase the limit with the actual time
     *
     * @param EventInterface $event
     */
    public function initializeLimitValue(EventInterface $event)
    {
        $this->timeLimit += microtime(true);
    }

    /**
     * Check if the consumer passed the limit
     *
     * @param ConsumerCycle $event
     */
    public function check(ConsumerCycle $event)
    {
        if ($this->timeLimit <= microtime(true)) {
            $event->stopConsumer();
        }
    }
}
