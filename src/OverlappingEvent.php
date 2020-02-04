<?php


namespace tsc\doubleBooked;


class OverlappingEvent
{

    private Event $mainEvent;
    private array $overlappingEvents;

    public function __construct(Event $mainEvent, $overlappingEvents = [])
    {
        $this->mainEvent = $mainEvent;
        $this->overlappingEvents = $overlappingEvents;
    }

    /**
     * event which is overlap
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->mainEvent;
    }

    /**
     * get events which overlapping "main" event
     *
     * @return Event[]
     */
    public function getOverlappingEvents(): array
    {
        return $this->overlappingEvents;
    }

}