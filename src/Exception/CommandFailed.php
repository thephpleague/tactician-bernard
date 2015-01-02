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

/**
 * Thrown when a command fails
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class CommandFailed extends \Exception
{
    /**
     * @var object
     */
    protected $command;

    /**
     * @param object          $command
     * @param string          $message
     * @param integer         $code
     * @param \Exception|null $previousException
     */
    public function __construct($command, $message = '', $code = 0, \Exception $previousException = null)
    {
        $this->command = $command;

        parent::__construct($message, $code, $previousException);
    }
}
