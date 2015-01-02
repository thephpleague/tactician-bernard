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

/**
 * Message wrapper for Commands
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class CommandMessage implements Message
{
    /**
     * @var object
     */
    protected $command;

    /**
     * @param object $command
     */
    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * Returns the command
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
        return get_class($this->command);
    }
}
