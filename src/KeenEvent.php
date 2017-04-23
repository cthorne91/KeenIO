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

    public function keenTitle()
    {
        return $this->keenTitle;
    }

    public function keenData()
    {
        return $this->mergeAddOns($this->keenData);
    }
}
