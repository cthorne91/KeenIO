<?php

namespace Sitruc\KeenIO;

use Sitruc\KeenIO\Concerns\AddOns;
use Sitruc\KeenIO\Concerns\SendsData;
use Sitruc\KeenIO\Contracts\KeenEvent as KeenEventInterface;

class KeenEvent implements KeenEventInterface
{
    use AddOns, SendsData;

    protected $keenTitle;

    protected $keenData;

    public function __construct($title, $data)
    {
        $this->keenTitle = $title;

        $this->keenData = $data;
    }

    public static function fromArguments($arguments)
    {
        if (empty($arguments)) {
            throw new \InvalidArgumentException('Invalid arguments given in '.__METHOD__.' on '.__CLASS__.'. Arguments cannot be empty.');
        }

        $event = $arguments[0];
        if (! ($event instanceof KeenEventInterface)) {
            $event = new static($arguments[0], $arguments[1]);
        }

        return $event;
    }

    public function keenTitle()
    {
        return $this->keenTitle;
    }

    public function keenData()
    {
        return $this->keenData;
    }

    public function keenDataWithAddOns()
    {
        return $this->mergeAddOns($this->keenData());
    }
}
