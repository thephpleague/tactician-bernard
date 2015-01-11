<?php

namespace spec\Doris\Event;

use League\Tactician\CommandBus\Command;
use PhpSpec\ObjectBehavior;

class CommandFailedSpec extends ObjectBehavior
{
    function let(Command $command, \Exception $e)
    {
        $this->beConstructedWith($command, $e);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Doris\Event\CommandFailed');
    }

    function it_is_a_command_event()
    {
        $this->shouldHaveType('Doris\Event\CommandEvent');
    }

    function it_has_an_exception(\Exception $e)
    {
        $this->getException()->shouldReturn($e);
    }
}
