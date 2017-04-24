<?php

namespace Sitruc\KeenIO\AddOns;

class IPAddressParser extends AddOn
{
    const inputkey = 'ip_address';

    protected $name = 'keen:ip_to_geo';

    public function __construct($input, $destination)
    {
        parent::__construct([self::inputkey => $input], $destination);
    }
}
