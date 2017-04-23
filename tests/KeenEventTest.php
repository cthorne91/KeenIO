<?php

namespace Sitruc\KeenIO\Test;

use Sitruc\KeenIO\KeenEvent;

class KeenEventTest extends \PHPUnit_Framework_TestCase
{
    public function test_title_and_data_are_set()
    {
        $event = new KeenEvent('A Title', ['key' => 'value']);
        $this->assertEquals('A Title', $event->keenTitle());
        $this->assertEquals('value', $event->keenData()['key']);
    }
    
    public function test_data_enrichment_enrichment()
    {
        $event = new KeenEvent('A Title', ['key' => 'value']);
      
        $fluentEvent = $event->enrichDatetime('timestamp', 'timestamp_info')
              ->enrichIpAddress('ip_address', 'ip_geo_info')
              ->enrichUserAgent('user_agent', 'user_agent_info')
              ->enrichURL('url', 'url_info')
              ->enrichReferrer('referrer_url', 'page_url', 'referrer_info');
       
        $this->assertInstanceOf(KeenEvent::class, $fluentEvent);

        $addOns = $event->keenData()['keen']['addons'];
        $this->assertDatetimeEnriched($addOns); 
        $this->assertIPAddressEnriched($addOns);
        $this->assertUserAgentEnriched($addOns);
        $this->assertURLEnriched($addOns);
        $this->assertReferrerEnriched($addOns);
    }

    protected function assertDatetimeEnriched($addOns)
    {
        $this->assertEquals('timestamp', $addOns[0]['input']['date_time']);
        $this->assertEquals('timestamp_info', $addOns[0]['output']);
    }

    protected function assertIPAddressEnriched($addOns)
    {
        $this->assertEquals('ip_address', $addOns[1]['input']['ip_address']);
        $this->assertEquals('ip_geo_info', $addOns[1]['output']);
    }

    protected function assertUserAgentEnriched($addOns)
    {
        $this->assertEquals('user_agent', $addOns[2]['input']['ua_string']);
        $this->assertEquals('user_agent_info', $addOns[2]['output']);
    }

    protected function assertURLEnriched($addOns)
    {
        $this->assertEquals('url', $addOns[3]['input']['url']);
        $this->assertEquals('url_info', $addOns[3]['output']);
    }

    protected function assertReferrerEnriched($addOns)
    {
        $this->assertEquals('referrer_url', $addOns[4]['input']['referrer_url']);
        $this->assertEquals('page_url', $addOns[4]['input']['page_url']);
        $this->assertEquals('referrer_info', $addOns[4]['output']);
    }
}
