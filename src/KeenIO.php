<?php

namespace Sitruc\KeenIO;

use KeenIO\Client\KeenIOClient;
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
        if ($method == 'addEvent') {
            $keenEvent = KeenEvent::fromArguments($arguments);

            return $this->client->addEvent($keenEvent->keenTitle(), $keenEvent->keenDataWithAddOns());
        }

        return $this->client->$method(...$arguments);
    }
}
