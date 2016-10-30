<?php

namespace spec\League\Tactician\Bernard;

use Bernard\Message;
use League\Tactician\Bernard\QueuedCommand;
use PhpSpec\ObjectBehavior;

final class QueuedCommandSpec extends ObjectBehavior
{
    function let(Message $command)
    {
        $this->beConstructedWith($command);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QueuedCommand::class);
    }

    function it_has_a_command_from_the_queue(Message $command)
    {
        $this->getCommand()->shouldReturn($command);
    }
}
