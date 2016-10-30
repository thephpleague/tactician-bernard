<?php

namespace League\Tactician\Bernard;

use Bernard\Message;

/**
 * Marker interface for commands able to be sent to a queue
 */
interface QueueableCommand extends Message
{
}
