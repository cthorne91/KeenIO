<?php

namespace Sitruc\KeenIO\AddOns;

class URLParser extends AddOn
{
    const inputkey = 'url';

    protected $name = 'keen:url_parser';

    public function __construct($input, $destination)
    {
        parent::__construct([self::inputkey => $input], $destination);
    }
}
