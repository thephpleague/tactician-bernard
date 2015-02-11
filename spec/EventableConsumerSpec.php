<?php

namespace spec\League\Tactician\Bernard;

use Bernard\Envelope;
use Bernard\Queue;
use League\Event\EmitterInterface;
use League\Tactician\Bernard\QueueableCommand;
use League\Tactician\Bernard\Listener\CommandLimit;
use League\Tactician\CommandBus;
use League\Tactician\EventableCommandBus;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EventableConsumerSpec extends ObjectBehavior
{
    function let(CommandBus $commandBus, EmitterInterface $emitter)
    {
        $commandBus = new EventableCommandBus($commandBus->getWrappedObject());

        $this->beConstructedWith($commandBus, $emitter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\EventableConsumer');
        $this->shouldHaveType('League\Tactician\Bernard\Consumer');
    }

    function it_executes_a_command(Queue $queue, CommandBus $commandBus, Envelope $envelope, QueueableCommand $command, EmitterInterface $emitter)
    {
        $envelope->getMessage()->willReturn($command);
        $queue->dequeue()->willReturn($envelope);
        $commandBus->execute($command)->shouldBeCalled();
        $queue->acknowledge($envelope)->shouldBeCalled();

        $that = $this;
        $emitter->emit(Argument::type('League\Tactician\Bernard\Event\ConsumerCycle'))->will(function() use($that) {
            $that->shutdown();
        });

        $this->consume($queue);
    }
}
