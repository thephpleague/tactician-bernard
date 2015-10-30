<?php

namespace spec\League\Tactician\Bernard;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QueueCommandSpec extends ObjectBehavior
{
    /**
     * @param \spec\League\Tactician\Bernard\Command $command
     */
    function let(Command $command)
    {
        $this->beConstructedWith($command);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\QueueCommand');
    }

    /**
     * @param \spec\League\Tactician\Bernard\Command $command
     */
    function it_has_a_command(Command $command)
    {
        $this->getCommand()->shouldReturn($command);
    }

    /**
     * @param \spec\League\Tactician\Bernard\Command $command
     */
    function it_guesses_the_name_by_default()
    {
        $this->beConstructedWith(new Command);

        $this->getName()->shouldReturn('Command');
    }

    /**
     * @param \spec\League\Tactician\Bernard\Command $command
     */
    function it_accepts_a_name(Command $command)
    {
        $this->beConstructedWith($command, 'customName');

        $this->getName()->shouldReturn('customName');
    }
}

class Command {}
