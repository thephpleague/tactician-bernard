<?php

namespace spec\Doris;

use Bernard\Queue;
use Tactician\CommandBus\Command;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RemoteCommandBusSpec extends ObjectBehavior
{
    function let(Queue $queue)
    {
        $this->beConstructedWith($queue);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Doris\RemoteCommandBus');
    }

    function it_is_a_command_bus()
    {
        $this->shouldImplement('Tactician\CommandBus\CommandBus');
    }

    function it_executes_a_command(Queue $queue, Command $command)
    {
        $queue->enqueue(Argument::type('Bernard\Envelope'))->shouldBeCalled();

        $this->execute($command);
    }
}
