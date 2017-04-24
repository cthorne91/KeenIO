<?php

namespace Sitruc\KeenIO\Test\Fakes;

use Sitruc\KeenIO\KeenEvent;
use PHPUnit_Framework_Assert as PHPUnit;

class KeenIOFake
{
    protected $sentEvents = [];

    protected $queuedEvents = [];

    public function __call($method, $arguments)
    {
        if ($method == 'addEvent') {                     
            $event = KeenEvent::fromArguments($arguments);

            $this->recordEvent($event);  
        }
    }

    public function assertSent($eventTitle)
    {  
        PHPUnit::assertTrue($this->arrayHasEventWithTitle($eventTitle, $this->sentEvents),"Failed asserting that event with title: \"{$eventTitle}\" was sent.");
    }

    public function assertQueued($eventTitle)
    {
        PHPUnit::assertTrue($this->arrayHasEventWithTitle($eventTitle, $this->queuedEvents),"Failed asserting that event with title: \"{$eventTitle}\" was queued.");
    }

    protected function arrayHasEventWithTitle($eventTitle, $array)
    {
        foreach ($array as $event) {
            if ($event->keenTitle() == $eventTitle) {
                return true;
            }
        }

        return false;
    }

    protected function recordEvent($event)
    {
        $event->willQueue()?
            $this->recordQueuedEvent($event):
            $this->recordSentEvent($event);
    }

    protected function recordQueuedEvent($event)
    {
        $this->queuedEvents[] = $event;
    }

    protected function recordSentEvent($event)
    {
        $this->sentEvents[] = $event;
    }
}
