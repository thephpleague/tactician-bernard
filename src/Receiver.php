<?php

namespace League\Tactician\Bernard;

use Bernard\Message;
use League\Tactician\CommandBus;

/**
 * Receives a Message from a Consumer.
 */
abstract class Receiver
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
     * Handles the message.
     *
     * @param Message $message
     */
    abstract public function handle(Message $message);

    /**
     * Makes the receiver callable to be able to register it in a router.
     *
     * @param Message $message
     *
     * @return mixed
     */
    public function __invoke(Message $message)
    {
        return $this->handle($message);
    }
}
