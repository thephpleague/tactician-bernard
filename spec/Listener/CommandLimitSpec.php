<?php

namespace spec\League\Tactician\Bernard\Listener;

use League\Event\ListenerAcceptorInterface;
use League\Tactician\CommandEvents\Event\CommandEvent;
use League\Tactician\Bernard\Consumer;
use PhpSpec\ObjectBehavior;

class CommandLimitSpec extends ObjectBehavior
{
    function let(Consumer $consumer)
    {
        $this->beConstructedWith($consumer, 1);
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
        $listenerAcceptor->addListener('commandExecuted', [$this, 'handle'])->shouldBeCalled();
        $listenerAcceptor->addListener('commandFailed', [$this, 'handle'])->shouldBeCalled();

        $this->provideListeners($listenerAcceptor);
    }

    function it_provides_less_listeners_when_it_does_not_count_failures(Consumer $consumer, ListenerAcceptorInterface $listenerAcceptor)
    {
        $this->beConstructedWith($consumer, 1, false);

        $listenerAcceptor->addListener('commandExecuted', [$this, 'handle'])->shouldBeCalled();

        $this->provideListeners($listenerAcceptor);
    }

    function it_checks_whether_consumer_should_run(Consumer $consumer, CommandEvent $event)
    {
        $this->beConstructedWith($consumer, 2);

        $consumer->shutdown()->shouldNotBeCalled();

        $this->handle($event);
    }

    function it_checks_whether_consumer_should_stop(Consumer $consumer, CommandEvent $event)
    {
        $this->handle($event);

        $consumer->shutdown()->shouldBeCalled();

        $this->handle($event);
    }
}
