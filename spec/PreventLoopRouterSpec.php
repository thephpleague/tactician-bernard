<?php

namespace spec\League\Tactician\Bernard;

use Bernard\Envelope;
use League\Tactician\Bernard\QueueableCommand;
use League\Tactician\CommandBus;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PreventLoopRouterSpec extends ObjectBehavior
{
    function let(CommandBus $commandBus)
    {
        $this->beConstructedWith($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\PreventLoopRouter');
    }

    function it_is_a_router()
    {
        $this->shouldImplement('Bernard\Router');
    }

    function it_maps_an_envelope(Envelope $envelope, QueueableCommand $command, CommandBus $commandBus)
    {
        $envelope->getMessage()->willReturn($command);
        $commandBus->handle(Argument::type('League\Tactician\Bernard\QueuedCommand'))->shouldBeCalled();

        $closure = $this->map($envelope);

        $closure->shouldHaveType('Closure');

        $closure();
    }

    function it_throws_an_exception_when_command_is_invalid(Envelope $envelope)
    {
        $envelope->getMessage()->willReturn(new \stdClass);

        $this->shouldThrow('Bernard\Exception\ReceiverNotFoundException')->duringMap($envelope);
    }
}
