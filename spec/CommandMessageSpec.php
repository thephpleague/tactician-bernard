<?php

namespace spec\Doris;

use Tactician\CommandBus\Command;
use PhpSpec\ObjectBehavior;

class CommandMessageSpec extends ObjectBehavior
{
    function let(Command $command)
    {
        $this->beConstructedWith($command);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Doris\CommandMessage');
        $this->shouldImplement('Bernard\Message');
    }

    function it_should_have_a_command(Command $command)
    {
        $this->getCommand()->shouldReturn($command);
    }

    function it_should_have_a_name(Command $command)
    {
        $this->getName()->shouldReturn(get_class($command->getWrappedObject()));
    }
}
