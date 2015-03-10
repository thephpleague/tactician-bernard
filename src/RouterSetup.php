<?php

namespace League\Tactician\Bernard;

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
}
