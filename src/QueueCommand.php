<?php

namespace League\Tactician\Bernard;

/**
 * Wraps any command to be queueable
 */
final class QueueCommand implements QueueableCommand
{
    /**
     * @var object
     */
    private $command;

    /**
     * @var string
     */
    private $name;

    /**
     * @param object      $command
     * @param string|null $name
     */
    public function __construct($command, $name = null)
    {
        $this->command = $command;

        if (is_null($name)) {
            $className = get_class($command);
            $name = substr($className, strrpos($className, '\\') + 1);
        }

        $this->name = $name;
    }

    /**
     * Returns the wrapped command
     *
     * @return object
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
}
