<?php

namespace League\Tactician\Bernard;

use Bernard\Envelope;
use Bernard\Exception\ReceiverNotFoundException;

/**
 * Command router to be used in Bernard\Consumer
 */
class PreventLoopRouter extends Router
{
    /**
     * {@inheritdoc}
     */
    public function map(Envelope $envelope)
    {
        if (!$envelope->getMessage() instanceof QueueableCommand) {
            throw new ReceiverNotFoundException();
        }

        return function () use ($envelope) {
            $queuedCommand = new QueuedCommand($envelope->getMessage());

            $this->commandBus->handle($queuedCommand);
        };
    }
}
