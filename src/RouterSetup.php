<?php

namespace League\Tactician\Bernard;

use Bernard\Message;
use Bernard\Router\SimpleRouter;
use League\Tactician\CommandBus;

/**
 * Helps in setting up a router used in a Consumer
 */
class RouterSetup
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
     * Sets up a router
     *
     * @param SimpleRouter $router
     */
    public function setUp(SimpleRouter $router)
    {
        $router->add('League\Tactician\Command', [$this->commandBus, 'handle']);
    }

    /**
     * Sets up a router with loop prevention
     *
     * @param SimpleRouter $router
     */
    public function setUpWithLoopPrevention(SimpleRouter $router)
    {
        $router->add('League\Tactician\Command', [$this, 'handleWithCommandWrapping']);
    }

    /**
     * Handles a command and prevents loop by wrapping it
     *
     * @param Message $message
     *
     * @return mixed
     */
    public function handleWithCommandWrapping(Message $message)
    {
        $queuedCommand = new QueuedCommand($message);

        return $this->commandBus->handle($queuedCommand);
    }
}
