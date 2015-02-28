<?php

namespace League\Tactician\Bernard;

use League\Tactician\Command;

/**
 * Creates a command wrapper for
 */
class CommandWrapper implements QueueableCommand
{
    use QueueDecision;

    /**
     * @var Command
     */
    protected $command;

    /**
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * Returns the command
     *
     * @return Command
     */
    public function getCommand()
    {
        return $command;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'wrapped_command';
    }
}
