<?php

namespace spec\Doris;

use PhpSpec\ObjectBehavior;

class CommandMessageSpec extends ObjectBehavior
{
    protected $commandObject;

    function let()
    {
        $this->beConstructedWith($this->commandObject = new \stdClass);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Doris\CommandMessage');
        $this->shouldHaveType('Bernard\Message');
    }

    function it_should_have_a_command()
    {
        $this->getCommand()->shouldReturn($this->commandObject);
    }

    function it_should_have_a_name()
    {
        $this->getName()->shouldReturn('stdClass');
    }
}
