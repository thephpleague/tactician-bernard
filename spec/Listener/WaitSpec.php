<?php

namespace spec\Doris\Listener;

use Doris\Event\ConsumerCycle;
use League\Event\ListenerAcceptorInterface;
use PhpSpec\ObjectBehavior;

class WaitSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(1, true);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Doris\Listener\Wait');
    }

    function it_is_a_listener_provider()
    {
        $this->shouldImplement('League\Event\ListenerProviderInterface');
    }

    function it_provides_listeners(ListenerAcceptorInterface $listenerAcceptor)
    {
        $listenerAcceptor->addListener('consumerCycle', [$this, 'wait'])->shouldBeCalled();

        $this->provideListeners($listenerAcceptor);
    }

    function it_waits_for_one_microsecond(ConsumerCycle $event)
    {
        $this->wait($event);
    }

    function it_waits_for_one_second(ConsumerCycle $event)
    {
        $this->beConstructedWith(1);

        $this->wait($event);
    }
}
