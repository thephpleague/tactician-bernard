<?php

namespace League\Tactician\Bernard;

use Bernard\Message;
use League\Tactician\Command;

/**
 * Creates a common interface for queueable commands
 */
interface QueueableCommand extends Command, Message
{
    /**
     * Checks whether the command should be queued or not
     *
     * @return boolean
     */
    public function shouldBeQueued();

    /**
     * Sets the queueability decision
     *
     * @param boolean $decision
     */
    public function setQueueDecision($decision = true);
}
