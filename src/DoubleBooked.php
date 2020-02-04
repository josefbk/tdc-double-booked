<?php

namespace tsc\doubleBooked;

class DoubleBooked
{
    /** @var Event[] */
    private $eventList = [];


    private function insert(Event $newEvent): void
    {
        $this->eventList[] = $newEvent;
    }

    /**
     * insert one or multiple events
     * @param Event ...$events
     */
    public function add(Event ...$events): void
    {
        foreach ($events as $event) {
            $this->insert($event);
        }
    }

    /**
     * return array of overlapping events
     *
     * @return OverlappingEvent[]
     */
    public function getOverlappingEvents(): array
    {
        $overlapping = [];
        $eventsCount = count($this->eventList);
        for ($i = 0; $i < $eventsCount; $i++) {
            $iOverlapping = [];
            for ($y = 0; $y < $eventsCount; $y++) {
                if (
                    $i != $y &&
                    (!($this->eventList[$i]->getStart() >= $this->eventList[$y]->getEnd() || $this->eventList[$i]->getEnd() <= $this->eventList[$y]->getStart()))
                ) {
                    $iOverlapping[] = clone $this->eventList[$y];
                }
            }
            if (!empty($iOverlapping)) {
                $overlapping[] = new OverlappingEvent(clone $this->eventList[$i], $iOverlapping);
            }
        }

        return $overlapping;
    }


}