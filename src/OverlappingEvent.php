<?php


namespace tsc\doubleBooked;


class OverlappingEvent
{

    private $mainEvent;
    private $overlappingEvents;

    public function __construct(Event $mainEvent, $overlappingEvents = [])
    {
        $this->mainEvent = $mainEvent;
        $this->overlappingEvents = $overlappingEvents;
    }

    public function getEvent(): Event
    {
        return $this->mainEvent;
    }

    /**
     * @return Event[]
     */
    public function getOverlappingEvents(): ?array
    {
        return $this->overlappingEvents;
    }

}