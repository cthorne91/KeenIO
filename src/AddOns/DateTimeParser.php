<?php

namespace Sitruc\KeenIO\AddOns;

class DateTimeParser extends AddOn
{
    const inputkey = 'date_time';

    protected $name = 'keen:date_time_parser';

    public function __construct($input, $destination)
    {
        parent::__construct([self::inputkey => $input], $destination);
    }
}
