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

use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;
use League\Tactician\BernardQueueing\Event\ConsumerCycle;

/**
 * Add a wait time to the consumer to slow down the infinite loop
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
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
        $listenerAcceptor->addListener('consumerCycle', [$this, 'wait']);
    }

    /**
     * Wait for the given time
     *
     * @param ConsumerCycle $event
     */
    public function wait(ConsumerCycle $event)
    {
        if ($this->microSeconds) {
            usleep($this->wait);

            return;
        }

        sleep($this->wait);
    }
}
