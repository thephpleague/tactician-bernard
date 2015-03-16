<?php

namespace spec\League\Tactician\Bernard;

use Bernard\Queue;
use League\Tactician\Command;
use League\Tactician\Middleware;
use League\Tactician\Bernard\QueueableCommand;
use League\Tactician\Bernard\QueuedCommand;
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
        $queue->enqueue(Argument::type('Bernard\Envelope'))->shouldBeCalled();

        $this->execute($command, function() {});
    }

    function it_executes_invokes_the_next_middleware(Queue $queue, QueuedCommand $wrappedCommand, Command $command, Middleware $middleware)
    {
        $queue->enqueue(Argument::type('Bernard\Envelope'))->shouldNotBeCalled();
        $wrappedCommand->getCommand()->willReturn($command);

        $next = function() {};
        $middleware->execute($command, $next)->willReturn(true);

        $this->execute(
            $wrappedCommand,
            function($command) use ($middleware, $next) {
                return $middleware->execute($command, $next);
            }
        );
    }
}
