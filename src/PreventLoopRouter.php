<?php

namespace League\Tactician\Bernard;

use Bernard\Envelope;
use Bernard\Exception\ReceiverNotFoundException;
use League\Tactician\Command;
use League\Tactician\CommandBus;

/**
 * Command router to be used in Bernard\Consumer
 */
class PreventLoopRouter implements \Bernard\Router
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * {@inheritdoc}
     */
    public function map(Envelope $envelope)
    {
        if (!$envelope->getMessage() instanceof Command) {
            throw new ReceiverNotFoundException();
        }

        return function () use ($envelope) {
            $queuedCommand = new QueuedCommand($envelope->getMessage());

            $this->commandBus->handle($queuedCommand);
        };
    }
}
