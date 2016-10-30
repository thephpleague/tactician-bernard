<?php

namespace League\Tactician\Bernard\Receiver;

use Bernard\Message;
use League\Tactician\Bernard\Receiver;

/**
 * Receives a Message from a Consumer and handles it
 */
final class SeparateBusReceiver extends Receiver
{
    /**
     * {@inheritdoc}
     */
    public function handle(Message $message)
    {
        return $this->commandBus->handle($message);
    }
}
