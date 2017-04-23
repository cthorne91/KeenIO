<?php

use Sitruc\KeenIO\AddOns\DateTimeParser;

class DateTimeParserTest extends PHPUnit_Framework_TestCase
{
    public function test_datetime_parser_can_initialize()
    {
        $parser = new DateTimeParser('source', 'destination.path');

        $array = $parser->toArray();

        $this->assertTrue(isset($array['name']));
        $this->assertTrue(isset($array['output']));
        $this->assertTrue(isset($array['input']));
        $this->assertTrue(isset($array['input']['date_time']));
        $this->assertEquals('keen:date_time_parser', $array['name']);
        $this->assertEquals('destination.path', $array['output']);
        $this->assertEquals('source', $array['input']['date_time']);
    }
}
