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

class EventableConsumerSpec extends ObjectBehavior
{
    function let(CommandBus $commandBus)
    {
        $commandBus = new EventableCommandBus($commandBus->getWrappedObject());

        $this->beConstructedWith($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\EventableConsumer');
        $this->shouldHaveType('League\Tactician\Bernard\Consumer');
    }

    function it_is_emitter_aware()
    {
        $this->shouldImplement('League\Event\EmitterAwareInterface');
    }

    function it_has_an_emitter()
    {
        $this->getEmitter()->shouldHaveType('League\Event\EmitterInterface');
    }

    function it_accepts_an_emitter(EmitterInterface $emitter)
    {
        $this->setEmitter($emitter);

        $this->getEmitter()->shouldReturn($emitter);
    }

    function it_executes_a_command(Queue $queue, CommandBus $commandBus, Envelope $envelope, QueueableCommand $command)
    {
        $envelope->getMessage()->willReturn($command);
        $queue->dequeue()->willReturn($envelope);
        $commandBus->execute($command)->shouldBeCalled();
        $queue->acknowledge($envelope)->shouldBeCalled();

        $this->useListenerProvider(new CommandLimit(1));

        $this->consume($queue);
    }
}
