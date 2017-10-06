<?php

namespace League\Tactician\Bernard;

use Bernard\Message\PlainMessage;
use Bernard\Util;

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
     * @var string
     */
    private $queueName;

    /**
     * @param object $command
     * @param string|null $name
     * @param string|null $queueName
     */
    public function __construct($command, $name = null, $queueName = null)
    {
        $this->command = $command;

        if (is_null($name)) {
            $className = get_class($command);
            $name = substr($className, strrpos($className, '\\') + 1);
        }

        if (null === $queueName) {
            $queueName = Util::guessQueue(new PlainMessage($name));

        }
        $this->name = $name;
        $this->queueName = $queueName;
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

    /**
     * @return string
     */
    public function getQueueName()
    {
        return $this->queueName;
    }
}
