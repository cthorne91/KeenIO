<?php

namespace Sitruc\KeenIO;

use KeenIO\Client\KeenIOClient;
use Sitruc\KeenIO\ReportEventQueued;
use Sitruc\KeenIO\Contracts\KeenEvent as KeenEventInterface;

class KeenIO
{
    protected $client;

    public function __construct(KeenIOClient $client)
    {
        $this->client = $client;
    }

    public function __call($method, $arguments)
    {
        if ($this->isCallingAddEventWithKeenData($method, $arguments)) {
            $keenEvent = $arguments[0];
            $arguments[0] = $keenEvent->keenTitle();
            $arguments[1] = $keenEvent->keenData();
        }

        return $this->client->$method(...$arguments);
    }

    public static function queue(KeenEventInterface $keenEvent)
    {
        dispatch(new ReportEventQueued($keenEvent));
    }

    protected function isCallingAddEventWithKeenData($method, $arguments)
    {
        return (
            $method == 'addEvent'&&
            count($arguments)&&
            $arguments[0] instanceof KeenEventInterface
        );
    }
}
