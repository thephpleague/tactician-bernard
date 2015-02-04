<?php

namespace spec\League\Tactician\BernardQueueing;

use Bernard\Envelope;
use Bernard\Queue;
use League\Tactician\BernardQueueing\QueueableCommand;
use League\Tactician\CommandBus;
use PhpSpec\ObjectBehavior;

class ConsumerSpec extends ObjectBehavior
{
    function let(CommandBus $commandBus)
    {
        $this->beConstructedWith($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\BernardQueueing\Consumer');
    }

    function it_executes_a_command(Queue $queue, CommandBus $commandBus, Envelope $envelope, QueueableCommand $command)
    {
        $that = $this;
        $envelope->getMessage()->willReturn($command);
        $queue->dequeue()->will(function ($args) use($that, $envelope) {
            $that->shutdown();

            return $envelope;
        });
        $commandBus->execute($command)->shouldBeCalled();
        $queue->acknowledge($envelope)->shouldBeCalled();

        $this->consume($queue);
    }
}
