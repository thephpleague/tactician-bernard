<?php

/*
 * This file is part of the Tactician Bernard Queueing package.
 *
 * (c) Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Tactician\Bernard;

use Bernard\Message;
use League\Tactician\Command;

/**
 * Creates a common interface for queueable commands
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface QueueableCommand extends Command, Message
{

}
