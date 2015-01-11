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

use League\Tactician\CommandBus\Command;

/**
 * Emitted when a command fails
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class CommandFailed extends CommandEvent
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'commandFailed';

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
        $this->exception = $exception;

        parent::__construct($command);
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
