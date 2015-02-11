<?php

/*
 * This file is part of the Tactician Bernard Queueing package.
 *
 * (c) Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Tactician\Bernard;

use Bernard\Queue;
use League\Event\EmitterInterface;
use League\Tactician\CommandBus;

/**
 * Provides an easy, event-driven was to consume and execute commands
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class EventableConsumer extends Consumer
{
    /**
     * @var EmitterInterface
     */
    protected $emitter;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus, EmitterInterface $emitter)
    {
        $this->emitter = $emitter;

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

            $this->emitter->emit($consumerCycleEvent);
        }
    }
}
