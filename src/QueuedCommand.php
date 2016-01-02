<?php

namespace League\Tactician\Bernard;

use Bernard\Message;

/**
 * Indicates the command has been queued or not.
 *
 * @final
 */
final class QueuedCommand
{
    /**
     * @var Message
     */
    protected $command;

    /**
     * @param Message $command
     */
    public function __construct(Message $command)
    {
        $this->command = $command;
    }

    /**
     * Returns the wrapped command.
     *
     * @return Message
     */
    public function getCommand()
    {
        return $this->command;
    }
}
