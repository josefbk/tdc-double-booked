# tdc-double-booked

simple class for checking overlapping events

Example
---

see _examples_ folder, can be run in _examples/cli.php_

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
    
    
output:    
    
    events:
    2000-01-01 0:00 - 2020-01-01 0:00
    2010-01-01 0:00 - 2030-01-01 0:00
    2020-01-01 0:00 - 2040-01-01 0:00
    
    2000-01-01 0:00 - 2020-01-01 0:00 is overlapping by:
            2010-01-01 0:00 - 2030-01-01 0:00
    2010-01-01 0:00 - 2030-01-01 0:00 is overlapping by:
            2000-01-01 0:00 - 2020-01-01 0:00
            2020-01-01 0:00 - 2040-01-01 0:00
    2020-01-01 0:00 - 2040-01-01 0:00 is overlapping by:
            2010-01-01 0:00 - 2030-01-01 0:00

    
    
    
Tests
===

run docker (in folder _/docker/_)
    
    docker-compose up -d
    
go to php container
    
    docker exec -ti php bash

go to code folder

    cd /code/

in container is composer in required

    curl -s https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer

update composer

    composer update
    
run tests in container: (in folder /code/)

    ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/DoubleBookedTest
    
