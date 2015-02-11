<?php

namespace spec\League\Tactician\Bernard\Event;

use League\Tactician\Bernard\Consumer;
use PhpSpec\ObjectBehavior;

class ConsumerCycleSpec extends ObjectBehavior
{
    function let(Consumer $consumer)
    {
        $this->beConstructedWith($consumer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\Event\ConsumerCycle');
    }

    function it_is_an_event()
    {
        $this->shouldImplement('League\Event\EventInterface');
    }

    function it_stops_a_consumer(Consumer $consumer)
    {
        $consumer->shutdown()->shouldBeCalled();

        $this->stopConsumer();
    }
}
