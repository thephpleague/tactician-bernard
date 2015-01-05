<?php

/*
 * This file is part of the Indigo Doris package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Doris;

use Bernard\Message;
use Tactician\CommandBus\Command;

/**
 * Message proxy for Commands
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class CommandProxy implements Message
{
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
        return $this->command;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return get_class($this->command);
    }
}
