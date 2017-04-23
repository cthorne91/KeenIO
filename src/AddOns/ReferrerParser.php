<?php

namespace Sitruc\KeenIO\AddOns;

class ReferrerParser extends AddOn
{
    const referrer_url = 'referrer_url';
    const page_url = 'page_url';

    protected $name = 'keen:referrer_parser';

    public function __construct($referrer_url_input, $page_url_input, $destination)
    {
        $input = [
            self::referrer_url => $referrer_url_input,
            self::page_url => $page_url_input,
        ];

        parent::__construct($input, $destination);
    }
}
