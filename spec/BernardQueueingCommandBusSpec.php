<?php

namespace spec\League\Tactician;

use Bernard\Queue;
use League\Tactician\Command;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BernardQueueingCommandBusSpec extends ObjectBehavior
{
    function let(Queue $queue)
    {
        $this->beConstructedWith($queue);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\BernardQueueingCommandBus');
    }

    function it_is_a_command_bus()
    {
        $this->shouldImplement('League\Tactician\CommandBus');
    }

    function it_executes_a_command(Queue $queue, Command $command)
    {
        $queue->enqueue(Argument::type('Bernard\Envelope'))->shouldBeCalled();

        $this->execute($command);
    }
}
