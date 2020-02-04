<?php

namespace tsc\doubleBooked;

class Event
{

    private int $start;
    private int $end;

    /**
     * Event constructor.
     * event's start and end as DateTime or timestamp
     *
     * @param \DateTime|int $start
     * @param \DateTime|int $end
     */
    public function __construct($start, $end)
    {
        if ($start instanceof \DateTime) {
            $this->start = $start->getTimestamp();
        } else {
            $this->start = $start;
        }

        if ($end instanceof \DateTime) {
            $this->end = $end->getTimestamp();
        } else {
            $this->end = $end;
        }
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function getEnd(): int
    {
        return $this->end;
    }

    public function __toString(): string
    {
        return (new \DateTime())->setTimestamp($this->getStart())->format('Y-m-d G:i') . " - " . (new \DateTime())->setTimestamp($this->getEnd())->format('Y-m-d G:i');
    }
}