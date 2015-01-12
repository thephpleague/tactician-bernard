<?php

namespace spec\Doris;

use Doris\CommandProxy;
use Doris\Listener\CommandLimit;
use Bernard\Envelope;
use Bernard\Queue;
use League\Event\EmitterInterface;
use League\Tactician\CommandBus\Command;
use League\Tactician\CommandBus\CommandBus;
use League\Tactician\CommandBus\EventableCommandBus;
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
        $this->shouldHaveType('Doris\EventableConsumer');
        $this->shouldHaveType('Doris\Consumer');
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
