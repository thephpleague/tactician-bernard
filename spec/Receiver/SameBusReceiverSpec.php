<?php

namespace spec\League\Tactician\Bernard\Receiver;

use Bernard\Message;
use League\Tactician\CommandBus;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class SameBusReceiverSpec extends ObjectBehavior
{
    function let(CommandBus $commandBus)
    {
        $this->beConstructedWith($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\Receiver\SameBusReceiver');
        $this->shouldHaveType('League\Tactician\Bernard\Receiver');
    }

    function it_handles_a_message(CommandBus $commandBus, Message $command)
    {
        $commandBus->handle(Argument::type('League\Tactician\Bernard\QueuedCommand'))->willReturn(true);

        $this->handle($command)->shouldReturn(true);
    }

    function it_is_invokable(CommandBus $commandBus, Message $command)
    {
        $commandBus->handle(Argument::type('League\Tactician\Bernard\QueuedCommand'))->willReturn(true);

        $this->__invoke($command)->shouldReturn(true);
    }
}
