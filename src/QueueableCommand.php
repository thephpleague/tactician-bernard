<?php

namespace League\Tactician\Bernard;

use Bernard\Message;
use League\Tactician\Command;

/**
 * Creates a common interface for queueable commands
 */
interface QueueableCommand extends Command, Message
{

}
