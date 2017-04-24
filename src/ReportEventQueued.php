<?php

namespace Sitruc\KeenIO;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sitruc\KeenIO\Contracts\KeenEvent as KeenEventInterface;

class ReportEventQueued implements ShouldQueue
{
    protected $event;

    public function __construct(KeenEventInterface $event)
    {
        $this->event = $event;
    }

    public function handle()
    {
        return \Sitruc\KeenIO\Facades\KeenIO::addEvent($this->event);
    }
}
