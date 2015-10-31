<?php

namespace spec\League\Tactician\Bernard\Receiver;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SameBusReceiverSpec extends ObjectBehavior
{
    /**
     * @param \League\Tactician\CommandBus $commandBus
     */
    function let($commandBus)
    {
        $this->beConstructedWith($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\Receiver\SameBusReceiver');
        $this->shouldHaveType('League\Tactician\Bernard\Receiver');
    }

    /**
     * @param \League\Tactician\CommandBus $commandBus
     * @param \Bernard\Message    $command
     */
    function it_handles_a_message($commandBus, $command)
    {
        $commandBus->handle(Argument::type('League\Tactician\Bernard\QueuedCommand'))->willReturn(true);

        $this->handle($command)->shouldReturn(true);
    }

    /**
     * @param \League\Tactician\CommandBus $commandBus
     * @param \Bernard\Message    $command
     */
    function it_is_invokable($commandBus, $command)
    {
        $commandBus->handle(Argument::type('League\Tactician\Bernard\QueuedCommand'))->willReturn(true);

        $this->__invoke($command)->shouldReturn(true);
    }
}
