<?php

use Sitruc\KeenIO\AddOns\URLParser;

class URLParserTest extends PHPUnit_Framework_TestCase
{
    public function test_url_parser_can_initialize()
    {
        $parser = new URLParser('source', 'destination.path');

        $array = $parser->toArray();

        $this->assertTrue(isset($array['name']));
        $this->assertTrue(isset($array['output']));
        $this->assertTrue(isset($array['input']));
        $this->assertTrue(isset($array['input']['url']));
        $this->assertEquals('keen:url_parser', $array['name']);
        $this->assertEquals('destination.path', $array['output']);
        $this->assertEquals('source', $array['input']['url']);
    }
}
