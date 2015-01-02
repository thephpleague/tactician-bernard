<?php

namespace spec\Doris;

use Doris\CommandMessage;
use Doris\Stub\TestCommand;
use Bernard\Queue;
use Bernard\Envelope;
use Tactician\CommandBus\CommandBus;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConsumerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Doris\Consumer');
    }

    function it_should_stop_when_stop_consumer_exception_thrown(Queue $queue, CommandBus $commandBus)
    {
        $queue->dequeue()->willThrow('Doris\Exception\StopConsumer');

        $this->consume($queue, $commandBus)->shouldReturn(null);
    }

    function it_should_allow_to_execute_a_command(Queue $queue, CommandBus $commandBus, Envelope $envelope, CommandMessage $commandMessage, TestCommand $command)
    {
        $commandMessage->getCommand()->willReturn($command);
        $envelope->getMessage()->willReturn($commandMessage);
        $queue->dequeue()->willReturn($envelope);
        $commandBus->execute($command)->shouldBeCalled();
        $queue->acknowledge($envelope)->shouldBeCalled();

        $this->beConstructedWith(1);

        $this->consume($queue, $commandBus);
    }
}
