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

    function it_is_an_event()
    {
        $this->shouldImplement('League\Event\EventInterface');
    }

    public function it_has_a_command(Command $command)
    {
        $this->getCommand()->shouldreturn($command);
    }

    function it_has_an_exception(\Exception $e)
    {
        $this->getException()->shouldReturn($e);
    }
}
