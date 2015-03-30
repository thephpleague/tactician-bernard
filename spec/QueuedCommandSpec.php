<?php

namespace spec\League\Tactician\Bernard;

use League\Tactician\Bernard\QueueableCommand;
use PhpSpec\ObjectBehavior;

class QueuedCommandSpec extends ObjectBehavior
{
    function let(QueueableCommand $command)
    {
        $this->beConstructedWith($command);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\QueuedCommand');
    }

    function it_has_a_queueable_command(QueueableCommand $command)
    {
        $this->getCommand()->shouldReturn($command);
    }
}
