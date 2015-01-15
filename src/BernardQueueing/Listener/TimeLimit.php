<?php

/*
 * This file is part of the Tactician Bernard Queueing package.
 *
 * (c) Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Tactician\BernardQueueing\Listener;

use League\Event\EventInterface;
use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;
use League\Tactician\BernardQueueing\Event\ConsumerCycle;

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
