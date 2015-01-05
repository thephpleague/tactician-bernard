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
