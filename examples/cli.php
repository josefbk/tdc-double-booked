<?php

require_once __DIR__."/../src/Event.php";
require_once __DIR__."/../src/OverlappingEvent.php";
require_once __DIR__."/../src/DoubleBooked.php";

use tsc\doubleBooked\DoubleBooked;
use tsc\doubleBooked\Event;
use tsc\doubleBooked\OverlappingEvent;

$db = new DoubleBooked();
$event1 = new Event( // 2000 - 2020, overlapping by event 2
    DateTime::createFromFormat('Y-m-d G:i', '2000-01-01 00:00'),
    DateTime::createFromFormat('Y-m-d G:i', '2020-01-01 00:00')
);
$event2 = new Event( // 2010 - 2030, overlapping by events 1 and 3
    DateTime::createFromFormat('Y-m-d G:i', '2010-01-01 00:00'),
    DateTime::createFromFormat('Y-m-d G:i', '2030-01-01 00:00')
);
$event3 = new Event( // 2020 - 2040, overlapping by event 2
    DateTime::createFromFormat('Y-m-d G:i', '2020-01-01 00:00'),
    DateTime::createFromFormat('Y-m-d G:i', '2040-01-01 00:00')
);

$db->add(
    $event1,
    $event2,
    $event3
);

$overlappingEvents = $db->getOverlappingEvents();

////
echo "\nevents:\n";
echo $event1 . "\n";
echo $event2 . "\n";
echo $event3 . "\n\n";

foreach ($overlappingEvents as $oe) {
    echo $oe->getEvent() . " is overlapping by:\n";
    foreach ($oe->getOverlappingEvents() as $o) {
        echo "\t" . $o."\n";
    }
}