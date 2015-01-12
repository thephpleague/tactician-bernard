<?php

/*
 * This file is part of the Indigo Doris package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Doris;

use Bernard\Queue;
use League\Event\EmitterInterface;
use League\Event\EmitterTrait;
use League\Tactician\CommandBus\EventableCommandBus;

/**
 * Provides an easy, event-driven was to consume and execute commands
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class EventableConsumer extends Consumer
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

            $this->emit($consumerCycleEvent);
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
