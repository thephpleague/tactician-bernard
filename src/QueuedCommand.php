<?php

namespace League\Tactician\Bernard;

/**
 * Indicates the command has been queued or not
 *
 * @final
 */
class QueuedCommand
{
    /**
     * @var QueueableCommand
     */
    protected $command;

    /**
     * @param QueueableCommand $command
     */
    public function __construct(QueueableCommand $command)
    {
        $this->command = $command;
    }

    /**
     * Returns the wrapped command
     *
     * @return QueueableCommand
     */
    public function getCommand()
    {
        return $this->command;
    }
}
