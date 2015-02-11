<?php

namespace spec\League\Tactician\Bernard\Listener;

use League\Event\EventInterface;
use League\Event\ListenerAcceptorInterface;
use League\Tactician\Bernard\Event\ConsumerCycle;
use PhpSpec\ObjectBehavior;

class CommandLimitSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\Listener\CommandLimit');
    }

    function it_is_a_listener_provider()
    {
        $this->shouldImplement('League\Event\ListenerProviderInterface');
    }

    function it_provides_listeners(ListenerAcceptorInterface $listenerAcceptor)
    {
        $listenerAcceptor->addListener('consumerCycle', [$this, 'check'])->shouldBeCalled();
        $listenerAcceptor->addListener('commandExecuted', [$this, 'count'])->shouldBeCalled();
        $listenerAcceptor->addListener('commandFailed', [$this, 'count'])->shouldBeCalled();

        $this->provideListeners($listenerAcceptor);
    }

    function it_provides_less_listeners_when_it_does_not_count_failures(ListenerAcceptorInterface $listenerAcceptor)
    {
        $this->beConstructedWith(1, false);

        $listenerAcceptor->addListener('consumerCycle', [$this, 'check'])->shouldBeCalled();
        $listenerAcceptor->addListener('commandExecuted', [$this, 'count'])->shouldBeCalled();

        $this->provideListeners($listenerAcceptor);
    }

    function it_checks_whether_consumer_should_run(ConsumerCycle $event)
    {
        $event->stopConsumer()->shouldNotBeCalled();

        $this->check($event);
    }

    function it_checks_whether_consumer_should_stop(EventInterface $countEvent, ConsumerCycle $cycleEvent)
    {
        $this->count($countEvent);

        $cycleEvent->stopConsumer()->shouldBeCalled();

        $this->check($cycleEvent);
    }
}
