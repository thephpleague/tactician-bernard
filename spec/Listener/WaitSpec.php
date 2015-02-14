<?php

namespace spec\League\Tactician\Bernard\Listener;

use League\Event\ListenerAcceptorInterface;
use League\Tactician\CommandEvents\Event\CommandEvent;
use PhpSpec\ObjectBehavior;

class WaitSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(1, true);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\Listener\Wait');
    }

    function it_is_a_listener_provider()
    {
        $this->shouldImplement('League\Event\ListenerProviderInterface');
    }

    function it_provides_listeners(ListenerAcceptorInterface $listenerAcceptor)
    {
        $listenerAcceptor->addListener('commandExecuted', [$this, 'handle'])->shouldBeCalled();
        $listenerAcceptor->addListener('commandFailed', [$this, 'handle'])->shouldBeCalled();

        $this->provideListeners($listenerAcceptor);
    }

    function it_waits_for_one_microsecond(CommandEvent $event)
    {
        $this->wait($event);
    }

    function it_waits_for_one_second(CommandEvent $event)
    {
        $this->beConstructedWith(1);

        $this->wait($event);
    }
}
