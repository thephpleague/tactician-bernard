<?php

namespace spec\League\Tactician\Bernard;

use League\Tactician\CommandBus;
use League\Tactician\Bernard\QueueableCommand;
use League\Tactician\Bernard\QueuedCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PreventLoopReceiverSpec extends ObjectBehavior
{
    function let(CommandBus $commandBus)
    {
        $this->beConstructedWith($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\PreventLoopReceiver');
        $this->shouldHaveType('League\Tactician\Bernard\Receiver');
    }

    function it_handles_a_message(CommandBus $commandBus, QueueableCommand $command)
    {
        $commandBus->handle(Argument::type('League\Tactician\Bernard\QueuedCommand'))->willReturn(true);

        $this->handle($command)->shouldReturn(true);
    }
}
