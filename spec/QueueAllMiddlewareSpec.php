<?php

namespace spec\League\Tactician\Bernard;

use League\Tactician\Bernard\QueueCommand;
use League\Tactician\Bernard\QueuedCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QueueAllMiddlewareSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\QueueAllMiddleware');
    }

    function it_is_a_middleware()
    {
        $this->shouldImplement('League\Tactician\Middleware');
    }

    /**
     * @param \League\Tactician\Middleware $middleware
     */
    function it_wraps_a_command($middleware)
    {
        $command = new \stdClass;
        $middleware->execute(Argument::type(QueueCommand::class), Argument::type('callable'))->shouldBeCalled();

        $this->execute(
            $command,
            function ($command) use ($middleware) {
                return $middleware->getWrappedObject()->execute($command, function () {});
            }
        );
    }


    /**
     * @param \League\Tactician\Middleware $middleware
     * @param \Bernard\Message             $command
     */
    function it_does_not_wrap_a_message($middleware, $command)
    {
        $middleware->execute($command, Argument::type('callable'))->shouldBeCalled();

        $this->execute(
            $command,
            function ($command) use ($middleware) {
                return $middleware->getWrappedObject()->execute($command, function () {});
            }
        );
    }

    /**
     * @param \League\Tactician\Middleware $middleware
     * @param \Bernard\Message             $command
     */
    function it_does_not_wrap_an_already_queued_command($middleware, $command)
    {
        $command = new QueuedCommand($command->getWrappedObject());
        $middleware->execute($command, Argument::type('callable'))->shouldBeCalled();

        $this->execute(
            $command,
            function ($command) use ($middleware) {
                return $middleware->getWrappedObject()->execute($command, function () {});
            }
        );
    }
}
