<?php

namespace Sitruc\KeenIO\Concerns;

use KeenIO;
use Sitruc\KeenIO\ReportEventQueued;
use Illuminate\Contracts\Queue\ShouldQueue;

trait SendsData
{
    protected $shouldQueue;

    public function send()
    {
        return dispatch($this->job());
    }

    public function handle()
    {
        return KeenIO::addEvent($this);
    }

    public function queue($shouldQueue = true)
    {
        $this->shouldQueue = $shouldQueue;
        
        return $this;
    }

    public function willQueue()
    {
        return (
            $this instanceof ShouldQueue||
            $this->shouldQueue
        );
    }

    protected function job()
    {
        if ($this instanceof ShouldQueue) {
            return $this;
        }

        if ($this->shouldQueue) {
            return new ReportEventQueued($this);
        }

        return $this;
    }
}
