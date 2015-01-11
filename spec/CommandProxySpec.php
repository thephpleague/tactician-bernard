<?php

namespace spec\Doris;

use League\Tactician\CommandBus\Command;
use PhpSpec\ObjectBehavior;

class CommandProxySpec extends ObjectBehavior
{
    function let(Command $command)
    {
        $this->beConstructedWith($command);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Doris\CommandProxy');
    }

    function it_is_a_message()
    {
        $this->shouldImplement('Bernard\Message');
    }

    function it_has_a_command(Command $command)
    {
        $this->getCommand()->shouldReturn($command);
    }

    function it_has_a_name(Command $command)
    {
        $this->getName()->shouldReturn(get_class($command->getWrappedObject()));
    }
}
