<?php

/*
 * This file is part of the Indigo Doris package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Doris\Event;

use League\Event\Event;
use League\Tactician\CommandBus\Command;

/**
 * Emitted when a command fails
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class CommandFailed extends Event
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'commandFailed';

    /**
     * @var Command
     */
    protected $command;

    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @param Command    $command
     * @param \Exception $exception
     */
    public function __construct(Command $command, \Exception $exception)
    {
        $this->command = $command;
        $this->exception = $exception;
    }

    /**
     * Returns the command
     *
     * @return Command
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Returns the exception
     *
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }
}
