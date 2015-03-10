<?php

namespace spec\League\Tactician\Bernard;

use Bernard\Producer;
use League\Tactician\Command;
use League\Tactician\Middleware;
use League\Tactician\Bernard\QueueableCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QueueMiddlewareSpec extends ObjectBehavior
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

    function it_executes_a_command(Producer $producer, QueueableCommand $command)
    {
        $producer->produce($command)->shouldBeCalled();

        $this->execute($command, function() {});
    }

    function it_executes_invokes_the_next_middleware(Producer $producer, Command $command, Middleware $middleware)
    {
        $producer->produce($command)->shouldNotBeCalled();
        $next = function() {};
        $middleware->execute($command, $next)->willReturn(true);

        $this->execute(
            $command,
            function($command) use ($middleware, $next) {
                return $middleware->execute($command, $next);
            }
        );
    }
}
