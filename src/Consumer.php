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
use Bernard\Envelope;
use League\Tactician\CommandBus\CommandBus;

/**
 * Consume commands from a queue and execute them
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Consumer
{
    use \League\Event\EmitterTrait;

    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * While this is true the loop will continue running
     *
     * @var boolean
     */
    protected $consume = true;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Starts an infinite loop
     *
     * @param Queue $queue
     */
    public function consume(Queue $queue)
    {
        $this->bind();

        $consumerCycleEvent = new Event\ConsumerCycle($this);

        while ($this->consume) {
            if ($envelope = $queue->dequeue()) {
                $this->process($queue, $envelope);
            }

            $this->emit($consumerCycleEvent);
        }
    }

    /**
     * Process the message
     *
     * @param Queue    $queue
     * @param Envelope $commandBus
     */
    protected function process(Queue $queue, Envelope $envelope)
    {
        $command = $this->getCommandFrom($envelope);

        try {
            $this->commandBus->execute($command);
            $queue->acknowledge($envelope);

            $this->emit(new Event\CommandExecuted($command));
        } catch (\Exception $e) {
            $this->emit(new Event\CommandFailed($command, $e));
        }
    }

    /**
     * Returns the command from the envelope
     *
     * @param Envelope $envelope
     *
     * @return Command
     */
    protected function getCommandFrom(Envelope $envelope)
    {
        $command = $envelope->getMessage();

        if ($command instanceof CommandProxy) {
            $command = $command->getCommand();
        }

        return $command;
    }

    /**
     * Set limits to an invalid value to shut down on the next cycle
     */
    public function shutdown()
    {
        $this->consume = false;
    }

    /**
     * Setup signal handlers for unix signals.
     */
    protected function bind()
    {
        pcntl_signal(SIGTERM, [$this, 'shutdown']);
        pcntl_signal(SIGQUIT, [$this, 'shutdown']);
        pcntl_signal(SIGINT,  [$this, 'shutdown']);
    }
}
