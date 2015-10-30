<?php

namespace spec\League\Tactician\Bernard;

use PhpSpec\ObjectBehavior;

class QueuedCommandSpec extends ObjectBehavior
{
    /**
     * @param \Bernard\Message $command
     */
    function let($command)
    {
        $this->beConstructedWith($command);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\QueuedCommand');
    }

    /**
     * @param \Bernard\Message $command
     */
    function it_has_a_queueable_command($command)
    {
        $this->getCommand()->shouldReturn($command);
    }
}
