<?php

namespace League\Tactician\Bernard;

/**
 * Helps deciding whether the command should be queued or not
 */
trait QueueDecision
{
    /**
     * @var boolean
     */
    protected $shouldBeQueued = true;

    /**
     * Checks whether the command should be queued or not
     *
     * @return boolean
     */
    public function shouldBeQueued()
    {
        return $this->shouldBeQueued;
    }

    /**
     * Sets the queue decision
     *
     * @param boolean $decision
     */
    public function setQueueDecision($decision = true)
    {
        $this->shouldBeQueued = (bool) $decision;
    }
}
