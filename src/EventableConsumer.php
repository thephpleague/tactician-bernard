<?php

/*
 * This file is part of the Tactician Bernard Queueing package.
 *
 * (c) Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Tactician\BernardQueueing;

use Bernard\Queue;
use League\Event\EmitterInterface;
use League\Event\EmitterAwareInterface;
use League\Event\EmitterTrait;
use League\Tactician\EventableCommandBus;

/**
 * Provides an easy, event-driven was to consume and execute commands
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class EventableConsumer extends Consumer implements EmitterAwareInterface
{
    use EmitterTrait;

    /**
     * @param EventableCommandBus $commandBus
     */
    public function __construct(EventableCommandBus $commandBus)
    {
        parent::__construct($commandBus);
    }

    /**
     * Starts an infinite loop
     *
     * @param Queue $queue
     */
    public function consume(Queue $queue)
    {
        $consumerCycleEvent = new Event\ConsumerCycle($this);

        while ($this->consume) {
            $this->doConsume($queue);

            $this->getEmitter()->emit($consumerCycleEvent);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getEmitter()
    {
        return $this->commandBus->getEmitter();
    }

    /**
     * {@inheritdoc}
     */
    public function setEmitter(EmitterInterface $emitter = null)
    {
        return $this->commandBus->setEmitter($emitter);
    }
}
