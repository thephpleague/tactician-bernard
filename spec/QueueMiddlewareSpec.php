<?php

namespace spec\League\Tactician\Bernard;

use Bernard\Queue;
use League\Tactician\Command;
use League\Tactician\Middleware;
use League\Tactician\Bernard\QueueableCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QueueMiddlewareSpec extends ObjectBehavior
{
    function let(Queue $queue)
    {
        $this->beConstructedWith($queue);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Tactician\Bernard\QueueMiddleware');
    }

    function it_is_a_middleware()
    {
        $this->shouldImplement('League\Tactician\Middleware');
    }

    function it_executes_a_command(Queue $queue, QueueableCommand $command)
    {
        $command->shouldBeQueued()->willReturn(true);

        $queue->enqueue(Argument::type('Bernard\Envelope'))->shouldBeCalled();

        $this->execute($command, function() {});
    }

    function it_executes_invokes_the_next_middleware(Queue $queue, QueueableCommand $command, Middleware $middleware)
    {
        $command->shouldBeQueued()->willReturn(false);
        $queue->enqueue(Argument::type('Bernard\Envelope'))->shouldNotBeCalled();
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
