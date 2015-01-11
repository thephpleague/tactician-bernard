<?php

namespace spec\Doris\Event;

use League\Tactician\CommandBus\Command;
use PhpSpec\ObjectBehavior;

class CommandExecutedSpec extends ObjectBehavior
{
    function let(Command $command)
    {
        $this->beConstructedWith($command);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Doris\Event\CommandExecuted');
    }

    function it_is_an_event()
    {
        $this->shouldImplement('League\Event\EventInterface');
    }

    public function it_has_a_command(Command $command)
    {
        $this->getCommand()->shouldreturn($command);
    }
}
