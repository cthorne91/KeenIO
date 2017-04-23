<?php

use Sitruc\KeenIO\AddOns\ReferrerParser;

class ReferrerParserTest extends PHPUnit_Framework_TestCase
{
    public function test_referrer_parser_can_initialize()
    {
        $parser = new ReferrerParser('r_url', 'p_url', 'destination.path');

        $array = $parser->toArray();

        $this->assertTrue(isset($array['name']));
        $this->assertTrue(isset($array['output']));
        $this->assertTrue(isset($array['input']));
        $this->assertTrue(isset($array['input']['referrer_url']));
        $this->assertTrue(isset($array['input']['page_url']));
        $this->assertEquals('keen:referrer_parser', $array['name']);
        $this->assertEquals('destination.path', $array['output']);
        $this->assertEquals('r_url', $array['input']['referrer_url']);
        $this->assertEquals('p_url', $array['input']['page_url']);
    }
}
