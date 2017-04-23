<?php

namespace Sitruc\KeenIO\AddOns;

abstract class AddOn
{
    /**
     * The name of the add on. ex: keen:referrer_parser
     *
     * @var string
     */
    protected $name;

    /**
     * The input array. ex: ['referrer_url' => 'the_referrer_url', 'page_url' => 'the_page_url']
     *
     * @var array
     */
    protected $input;

    /**
     * The location to put the parsed data. ex: referrer.info
     *
     * @var string
     */
    protected $output;

    public function __construct($input, $output)
    {
        $this->input = $input;

        $this->output = $output;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'output' => $this->output,
            'input' => $this->input,
        ];
    }
}
