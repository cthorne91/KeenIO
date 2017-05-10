<?php

use Sitruc\KeenIO\AddOns\IPAddressParser;

class IPAddressParserTest extends PHPUnit_Framework_TestCase
{
    public function test_ipaddress_parser_can_initialize()
    {
        $parser = new IPAddressParser('source', 'destination.path');

        $array = $parser->toArray();

        $this->assertTrue(isset($array['name']));
        $this->assertTrue(isset($array['output']));
        $this->assertTrue(isset($array['input']));
        $this->assertTrue(isset($array['input']['ip']));
        $this->assertEquals('keen:ip_to_geo', $array['name']);
        $this->assertEquals('destination.path', $array['output']);
        $this->assertEquals('source', $array['input']['ip']);
    }
}
