<?php

namespace spec\Doris;

use Bernard\Queue;
use Doris\Stub\TestCommand;
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
        $this->shouldHaveType('Tactician\CommandBus\CommandBus');
    }

    function it_should_allow_to_execute_a_command(Queue $queue, TestCommand $command)
    {
        $queue->enqueue(Argument::type('Bernard\Envelope'))->shouldBeCalled();

        $this->execute($command);
    }
}
