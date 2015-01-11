<?php

namespace spec\Doris\Stub;

use League\Tactician\CommandBus\Command;
use PhpSpec\ObjectBehavior;

class CommandEventSpec extends ObjectBehavior
{
    function let(Command $command)
    {
        $this->beConstructedWith($command);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Doris\Stub\CommandEvent');
    }

    function it_is_an_event()
    {
        $this->shouldHaveType('Doris\Event\CommandEvent');
        $this->shouldImplement('League\Event\EventInterface');
    }

    public function it_has_a_command(Command $command)
    {
        $this->getCommand()->shouldreturn($command);
    }
}
