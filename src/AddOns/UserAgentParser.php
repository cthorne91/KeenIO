<?php

namespace Sitruc\KeenIO\AddOns;

class UserAgentParser extends AddOn
{
    const inputkey = 'ua_string';

    protected $name = 'keen:ua_parser';

    public function __construct($input, $destination)
    {
        parent::__construct([self::inputkey => $input], $destination);
    }
}
