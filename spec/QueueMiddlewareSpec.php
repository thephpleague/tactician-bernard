<?php

namespace spec\League\Tactician\Bernard;

use Bernard\Message;
use Bernard\Producer;
use League\Tactician\Bernard\QueuedCommand;
use League\Tactician\Bernard\QueueMiddleware;
use League\Tactician\Middleware;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class QueueMiddlewareSpec extends ObjectBehavior
{
    function let(Producer $producer)
    {
        $this->beConstructedWith($producer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QueueMiddleware::class);
    }

    function it_is_a_middleware()
    {
        $this->shouldImplement(Middleware::class);
    }

    function it_executes_a_command(Producer $producer, Message $command)
    {
        $producer->produce($command)->shouldBeCalled();

        $this->execute($command, function () {});
    }

    function it_executes_invokes_the_next_middleware(Producer $producer, Middleware $middleware, Command $command)
    {
        $producer->produce($command)->shouldNotBeCalled();

        $middleware->execute($command, Argument::type('callable'))->shouldBeCalled();

        $this->execute(
            $command,
            function ($command) use ($middleware) {
                return $middleware->getWrappedObject()->execute($command, function () {});
            }
        );
    }

    function it_unwraps_a_command(Producer $producer, Message $command, Middleware $middleware)
    {
        $queuedCommand = new QueuedCommand($command->getWrappedObject());
        $producer->produce($command)->shouldNotBeCalled();

        $middleware->execute($command, Argument::type('callable'))->shouldBeCalled();

        $this->execute(
            $queuedCommand,
            function ($command) use ($middleware) {
                return $middleware->getWrappedObject()->execute($command, function () {});
            }
        );
    }
}
