<?php

namespace League\Tactician\Bernard\Receiver;

use Bernard\Message;
use League\Tactician\Bernard\Receiver;
use League\Tactician\Bernard\QueuedCommand;

/**
 * Receives a Message from a Consumer and handles it (additionally prevents it from being requeued).
 */
class SameBusReceiver extends Receiver
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
