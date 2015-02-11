<?php

namespace spec\League\Tactician\Bernard\Listener;

use League\Event\EventInterface;
use League\Event\ListenerAcceptorInterface;
use League\Tactician\Bernard\Event\ConsumerCycle;
use PhpSpec\ObjectBehavior;

class TimeLimitSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\Listener\TimeLimit');
    }

    function it_is_a_listener_provider()
    {
        $this->shouldImplement('League\Event\ListenerProviderInterface');
    }

    function it_provides_listeners(ListenerAcceptorInterface $listenerAcceptor)
    {
        $listenerAcceptor->addListener('consumerCycle', [$this, 'check'])->shouldBeCalled();

        $this->provideListeners($listenerAcceptor);
    }

    function it_checks_whether_consumer_should_run(ConsumerCycle $event)
    {
        $this->beConstructedWith(10);

        $event->stopConsumer()->shouldNotBeCalled();

        $this->check($event);
    }

    function it_checks_whether_consumer_should_stop(EventInterface $startEvent, ConsumerCycle $cycleEvent)
    {
        $this->beConstructedWith(-1);

        $cycleEvent->stopConsumer()->shouldBeCalled();

        $this->check($cycleEvent);
    }
}
