<?php

namespace spec\League\Tactician\Bernard\Listener;

use League\Event\ListenerAcceptorInterface;
use League\Tactician\CommandEvents\CommandEvent;
use League\Tactician\Bernard\Consumer;
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
        $listenerAcceptor->addListener('commandExecuted', [$this, 'handle'])->shouldBeCalled();
        $listenerAcceptor->addListener('commandFailed', [$this, 'handle'])->shouldBeCalled();

        $this->provideListeners($listenerAcceptor);
    }

    function it_provides_less_listeners_when_it_does_not_count_failures(ListenerAcceptorInterface $listenerAcceptor)
    {
        $this->beConstructedWith(1, false);

        $listenerAcceptor->addListener('commandExecuted', [$this, 'handle'])->shouldBeCalled();

        $this->provideListeners($listenerAcceptor);
    }

    function it_checks_whether_consumer_should_run(CommandEvent $event, Consumer $consumer)
    {
        $this->beConstructedWith(2);
        $this->setConsumer($consumer);

        $consumer->shutdown()->shouldNotBeCalled();

        $this->handle($event);
    }

    function it_checks_whether_consumer_should_stop(CommandEvent $event, Consumer $consumer)
    {
        $this->setConsumer($consumer);

        $this->handle($event);

        $consumer->shutdown()->shouldBeCalled();

        $this->handle($event);
    }
}
