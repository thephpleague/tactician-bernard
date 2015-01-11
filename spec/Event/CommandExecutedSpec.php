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

    function it_is_a_command_event()
    {
        $this->shouldHaveType('Doris\Event\CommandEvent');
    }
}
