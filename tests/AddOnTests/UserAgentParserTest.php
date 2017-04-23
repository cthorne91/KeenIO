<?php

use Sitruc\KeenIO\AddOns\UserAgentParser;

class UserAgentParserTest extends PHPUnit_Framework_TestCase
{
    public function test_user_agent_parser_can_initialize()
    {
        $parser = new UserAgentParser('source', 'destination.path');

        $array = $parser->toArray();

        $this->assertTrue(isset($array['name']));
        $this->assertTrue(isset($array['output']));
        $this->assertTrue(isset($array['input']));
        $this->assertTrue(isset($array['input']['ua_string']));
        $this->assertEquals('keen:ua_parser', $array['name']);
        $this->assertEquals('destination.path', $array['output']);
        $this->assertEquals('source', $array['input']['ua_string']);
    }
}
