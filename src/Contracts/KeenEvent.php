<?php

namespace Sitruc\KeenIO\Contracts;

interface KeenEvent
{
    /**
     * Get the title for the event.
     *
     * @return string The event title
     */
    public function keenTitle();

    /**
     * Get the data for the event.
     *
     * @return array the data for the event.
     */
    public function keenData();
}
