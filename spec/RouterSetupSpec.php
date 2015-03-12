<?php

namespace spec\League\Tactician\Bernard;

use League\Tactician\CommandBus;
use Bernard\Router\SimpleRouter;
use PhpSpec\ObjectBehavior;

class RouterSetupSpec extends ObjectBehavior
{
    function let(CommandBus $commandBus)
    {
        $this->beConstructedWith($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\RouterSetup');
    }

    function it_sets_a_router_up(SimpleRouter $router, CommandBus $commandBus)
    {
        $router->add('League\Tactician\Command', [$commandBus, 'handle'])->shouldBeCalled();

        $this->setUp($router);
    }

    function it_sets_a_router_up_with_loop_prevention(SimpleRouter $router, CommandBus $commandBus)
    {
        $router->add('League\Tactician\Command', [$this, 'handleWithCommandWrapping'])->shouldBeCalled();

        $this->setUpWithLoopPrevention($router);
    }
}
