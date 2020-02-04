<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use tsc\doubleBooked\DoubleBooked;
use tsc\doubleBooked\Event;

final class DoubleBookedTest extends TestCase
{

    /**
     * no overlapping events
     */
    public function testCase1(): void
    {
        $db = new DoubleBooked();

        $event1 = new Event(
            DateTime::createFromFormat('Y-m-d G:i', '2007-01-01 00:00'),
            DateTime::createFromFormat('Y-m-d G:i', '2008-01-01 00:00')
        );
        $event2 = new Event(
            DateTime::createFromFormat('Y-m-d G:i', '2008-01-01 00:00'),
            DateTime::createFromFormat('Y-m-d G:i', '2010-01-01 00:00')
        );

        $db->add(
            $event1,
            $event2,
            );

        $oe = $db->getOverlappingEvents();

        $this->assertEquals(0, count($oe));

    }


    /**
     * 3 overlapping events
     */
    public function testCase2(): void
    {
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

        $oe = $db->getOverlappingEvents();

        $this->assertEquals(3, count($oe));

        $this->assertEquals(1, count($oe[0]->getOverlappingEvents()));
        $this->assertEquals(2, count($oe[1]->getOverlappingEvents()));
        $this->assertEquals(1, count($oe[2]->getOverlappingEvents()));

        echo "\nevents:\n";
        echo $event1 . "\n";
        echo $event2 . "\n";
        echo $event3 . "\n";

        foreach ($oe as $o) {
            echo $o->getEvent() . " is overlapping by:\n";
            foreach ($o->getOverlappingEvents() as $o) {
                echo "\t" . $o."\n";
            }
        }

    }
}