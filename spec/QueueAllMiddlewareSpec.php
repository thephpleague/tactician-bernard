<?php

namespace spec\League\Tactician\Bernard;

use Bernard\Message;
use League\Tactician\Bernard\QueueAllMiddleware;
use League\Tactician\Bernard\QueueCommand;
use League\Tactician\Bernard\QueuedCommand;
use League\Tactician\Middleware;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class QueueAllMiddlewareSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(QueueAllMiddleware::class);
    }

    function it_is_a_middleware()
    {
        $this->shouldImplement(Middleware::class);
    }

    function it_wraps_a_command(Middleware $middleware, Command $command)
    {
        $middleware->execute(Argument::type(QueueCommand::class), Argument::type('callable'))->shouldBeCalled();

        $this->execute(
            $command,
            function ($command) use ($middleware) {
                return $middleware->getWrappedObject()->execute($command, function () {});
            }
        );
    }


    function it_does_not_wrap_a_message(Middleware $middleware, Message $command)
    {
        $middleware->execute($command, Argument::type('callable'))->shouldBeCalled();

        $this->execute(
            $command,
            function ($command) use ($middleware) {
                return $middleware->getWrappedObject()->execute($command, function () {});
            }
        );
    }

    function it_does_not_wrap_an_already_queued_command(Middleware $middleware, Message $command)
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
