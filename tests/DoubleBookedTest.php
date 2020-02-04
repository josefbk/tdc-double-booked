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

        $event1 = new Event( //2000 - 2010
            DateTime::createFromFormat('Y-m-d G:i', '2000-01-01 00:00'),
            DateTime::createFromFormat('Y-m-d G:i', '2010-01-01 00:00')
        );
        $event2 = new Event( //2020 - 2030
            DateTime::createFromFormat('Y-m-d G:i', '2020-01-01 00:00'),
            DateTime::createFromFormat('Y-m-d G:i', '2030-01-01 00:00')
        );
        $event3 = new Event( //2030 - 2040
            DateTime::createFromFormat('Y-m-d G:i', '2030-01-01 00:00'),
            DateTime::createFromFormat('Y-m-d G:i', '2040-01-01 00:00')
        );

        $db->add(
            $event1,
            $event2,
            $event3
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
    }

    public function testCase3(): void
    {
        $db = new DoubleBooked();
        $event1 = new Event( // 2000 - 2020, overlapping by event 2
            DateTime::createFromFormat('Y-m-d G:i', '2000-01-01 00:00'),
            DateTime::createFromFormat('Y-m-d G:i', '2020-01-01 00:00')
        );
        $event2 = new Event( // 2010 - 2011, overlapping by event 1
            DateTime::createFromFormat('Y-m-d G:i', '2010-01-01 00:00'),
            DateTime::createFromFormat('Y-m-d G:i', '2011-01-01 00:00')
        );
        $event3 = new Event( // 2020 - 2040, no overlapping
            DateTime::createFromFormat('Y-m-d G:i', '2020-01-01 00:00'),
            DateTime::createFromFormat('Y-m-d G:i', '2040-01-01 00:00')
        );

        $db->add(
            $event1,
            $event2,
            $event3
        );

        $oe = $db->getOverlappingEvents();

        $this->assertEquals(2, count($oe));

        $this->assertEquals(1, count($oe[0]->getOverlappingEvents()));
        $this->assertEquals(1, count($oe[1]->getOverlappingEvents()));

        $this->assertEquals($event1, $oe[0]->getEvent());
        $this->assertEquals([$event2], $oe[0]->getOverlappingEvents());

        $this->assertEquals($event2, $oe[1]->getEvent());
        $this->assertEquals([$event1], $oe[1]->getOverlappingEvents());
    }
}