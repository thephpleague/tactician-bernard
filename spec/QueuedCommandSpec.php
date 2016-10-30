<?php

namespace spec\League\Tactician\Bernard;

use Bernard\Message;
use PhpSpec\ObjectBehavior;

final class QueuedCommandSpec extends ObjectBehavior
{
    function let(Message $command)
    {
        $this->beConstructedWith($command);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\QueuedCommand');
    }

    function it_has_a_queueable_command(Message $command)
    {
        $this->getCommand()->shouldReturn($command);
    }
}
