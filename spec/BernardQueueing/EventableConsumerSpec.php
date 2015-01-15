<?php

namespace spec\League\Tactician\BernardQueueing;

use Bernard\Envelope;
use Bernard\Queue;
use League\Event\EmitterInterface;
use League\Tactician\BernardQueueing\CommandProxy;
use League\Tactician\BernardQueueing\Listener\CommandLimit;
use League\Tactician\Command;
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
        $this->shouldHaveType('League\Tactician\BernardQueueing\EventableConsumer');
        $this->shouldHaveType('League\Tactician\BernardQueueing\Consumer');
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
}
