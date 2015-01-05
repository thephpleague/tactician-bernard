<?php

namespace spec\Doris;

use Doris\CommandMessage;
use Doris\Listener\CommandLimit;
use Doris\Exception\CommandFailed;
use Bernard\Queue;
use Bernard\Envelope;
use Tactician\CommandBus\CommandBus;
use Tactician\CommandBus\Command;
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

    function it_should_allow_to_execute_a_command(Queue $queue, CommandBus $commandBus, Envelope $envelope, CommandMessage $commandMessage, Command $command)
    {
        $commandMessage->getCommand()->willReturn($command);
        $envelope->getMessage()->willReturn($commandMessage);
        $queue->dequeue()->willReturn($envelope);
        $commandBus->execute($command)->shouldBeCalled();
        $queue->acknowledge($envelope)->shouldBeCalled();

        $this->useListenerProvider(new CommandLimit(1));

        $this->consume($queue, $commandBus);
    }

    function it_should_cycle_when_no_command_received(Queue $queue, CommandBus $commandBus, Envelope $envelope, CommandMessage $commandMessage, Command $command)
    {
        $commandMessage->getCommand()->willReturn($command);
        $envelope->getMessage()->willReturn($commandMessage);
        $queue->dequeue()->will(function($args) use ($envelope) {
            $this->dequeue()->willReturn($envelope);
        });
        $commandBus->execute($command)->shouldBeCalled();
        $queue->acknowledge($envelope)->shouldBeCalled();

        $this->useListenerProvider(new CommandLimit(1));

        $this->consume($queue, $commandBus);
    }

    function it_should_allow_to_handle_a_command_failure(Queue $queue, CommandBus $commandBus, Envelope $envelope, CommandMessage $commandMessage, Command $command)
    {
        $commandMessage->getCommand()->willReturn($command);
        $envelope->getMessage()->willReturn($commandMessage);
        $queue->dequeue()->willReturn($envelope);
        $commandBus->execute($command)->willThrow(new CommandFailed($command));
        $queue->acknowledge($envelope)->shouldNotBeCalled();

        $this->useListenerProvider(new CommandLimit(1));

        $this->consume($queue, $commandBus);
    }

    function it_should_allow_to_handle_a_command_error(Queue $queue, CommandBus $commandBus, Envelope $envelope, CommandMessage $commandMessage, Command $command)
    {
        $commandMessage->getCommand()->willReturn($command);
        $envelope->getMessage()->willReturn($commandMessage);
        $queue->dequeue()->willReturn($envelope);
        $commandBus->execute($command)->willThrow('Exception');
        $queue->acknowledge($envelope)->shouldNotBeCalled();

        $this->useListenerProvider(new CommandLimit(1));

        $this->consume($queue, $commandBus);
    }
}
