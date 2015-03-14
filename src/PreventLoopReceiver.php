<?php

namespace League\Tactician\Bernard;

use Bernard\Message;

/**
 * Receives a Message from a Consumer and handles it (additionally prevents it from being requeued)
 */
class PreventLoopReceiver extends Receiver
{
    /**
     * {@inheritdoc}
     */
    public function handle(Message $message)
    {
        $queuedCommand = new QueuedCommand($message);

        return $this->commandBus->handle($queuedCommand);
    }
}
