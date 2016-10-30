<?php

namespace spec\League\Tactician\Bernard;

use PhpSpec\ObjectBehavior;

class QueueCommandSpec extends ObjectBehavior
{
    function let(Command $command)
    {
        $this->beConstructedWith($command);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\QueueCommand');
    }

    function it_has_a_command(Command $command)
    {
        $this->getCommand()->shouldReturn($command);
    }

    function it_guesses_the_name_by_default()
    {
        $this->beConstructedWith(new Command());

        $this->getName()->shouldReturn('Command');
    }

    function it_accepts_a_name(Command $command)
    {
        $this->beConstructedWith($command, 'customName');

        $this->getName()->shouldReturn('customName');
    }
}
