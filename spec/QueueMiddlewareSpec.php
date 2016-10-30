<?php

namespace spec\League\Tactician\Bernard;

use Bernard\Message;
use Bernard\Producer;
use League\Tactician\Bernard\QueuedCommand;
use League\Tactician\Middleware;
use PhpSpec\ObjectBehavior;

final class QueueMiddlewareSpec extends ObjectBehavior
{
    function let(Producer $producer)
    {
        $this->beConstructedWith($producer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\QueueMiddleware');
    }

    function it_is_a_middleware()
    {
        $this->shouldImplement('League\Tactician\Middleware');
    }

    function it_executes_a_command(Producer $producer, Message $command)
    {
        $producer->produce($command)->shouldBeCalled();

        $this->execute(
            $command,
            function () {}
        );
    }

    function it_executes_invokes_the_next_middleware(Producer $producer, Middleware $middleware, Command $command)
    {
        $producer->produce($command)->shouldNotBeCalled();
        $next = function () {};
        $middleware->execute($command, $next)->willReturn(true);

        $this->execute(
            $command,
            function ($command) use ($middleware, $next) {
                return $middleware->execute($command, $next);
            }
        );
    }

    function it_unwraps_a_command(Producer $producer, Message $command, Middleware $middleware)
    {
        $queuedCommand = new QueuedCommand($command->getWrappedObject());
        $producer->produce($command)->shouldNotBeCalled();
        $next = function () {};
        $middleware->execute($command, $next)->willReturn(true);

        $this->execute(
            $queuedCommand,
            function ($command) use ($middleware, $next) {
                return $middleware->execute($command, $next);
            }
        );
    }
}
