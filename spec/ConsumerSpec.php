<?php

namespace spec\Doris;

use Doris\CommandProxy;
use Doris\Exception\CommandFailed;
use Doris\Listener\CommandLimit;
use Bernard\Envelope;
use Bernard\Queue;
use League\Tactician\CommandBus\Command;
use League\Tactician\CommandBus\CommandBus;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConsumerSpec extends ObjectBehavior
{
    function let(CommandBus $commandBus)
    {
        $this->beConstructedWith($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Doris\Consumer');
    }

    function it_stops_when_stop_consumer_exception_thrown(Queue $queue)
    {
        $queue->dequeue()->willThrow('Doris\Exception\StopConsumer');

        $this->consume($queue);
    }

    function it_executes_a_command(Queue $queue, CommandBus $commandBus, Envelope $envelope, CommandProxy $commandProxy, Command $command)
    {
        $commandProxy->getCommand()->willReturn($command);
        $envelope->getMessage()->willReturn($commandProxy);
        $queue->dequeue()->willReturn($envelope);
        $commandBus->execute($command)->shouldBeCalled();
        $queue->acknowledge($envelope)->shouldBeCalled();

        $this->useListenerProvider(new CommandLimit(1));

        $this->consume($queue);
    }

    function it_cycles_when_no_command_received(Queue $queue, CommandBus $commandBus, Envelope $envelope, CommandProxy $commandProxy, Command $command)
    {
        $commandProxy->getCommand()->willReturn($command);
        $envelope->getMessage()->willReturn($commandProxy);
        $queue->dequeue()->will(function($args) use ($envelope) {
            $this->dequeue()->willReturn($envelope);
        });
        $commandBus->execute($command)->shouldBeCalled();
        $queue->acknowledge($envelope)->shouldBeCalled();

        $this->useListenerProvider(new CommandLimit(1));

        $this->consume($queue);
    }

    function it_handles_a_command_failure(Queue $queue, CommandBus $commandBus, Envelope $envelope, CommandProxy $commandProxy, Command $command)
    {
        $commandProxy->getCommand()->willReturn($command);
        $envelope->getMessage()->willReturn($commandProxy);
        $queue->dequeue()->willReturn($envelope);
        $commandBus->execute($command)->willThrow(new CommandFailed($command));
        $queue->acknowledge($envelope)->shouldNotBeCalled();

        $this->useListenerProvider(new CommandLimit(1));

        $this->consume($queue);
    }

    function it_handles_a_command_error(Queue $queue, CommandBus $commandBus, Envelope $envelope, CommandProxy $commandProxy, Command $command)
    {
        $commandProxy->getCommand()->willReturn($command);
        $envelope->getMessage()->willReturn($commandProxy);
        $queue->dequeue()->willReturn($envelope);
        $commandBus->execute($command)->willThrow('Exception');
        $queue->acknowledge($envelope)->shouldNotBeCalled();

        $this->useListenerProvider(new CommandLimit(1));

        $this->consume($queue);
    }
}
