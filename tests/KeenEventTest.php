<?php

namespace Sitruc\KeenIO\Test;

use KeenIO;
use Sitruc\KeenIO\KeenEvent;
use Sitruc\KeenIO\Test\Fakes\KeenIOFake;
use Illuminate\Contracts\Queue\ShouldQueue; 

class KeenEventTest extends TestCase 
{
    public function test_with_arguments_static_initializer_with_title_array()
    {
        $event = KeenEvent::fromArguments(['A Title', ['key' => 'value']]);

        $this->assertEquals('A Title', $event->keenTitle());
        $this->assertEquals('value', $event->keenData()['key']);
    }

    public function test_with_arguments_static_initializer_with_event()
    {
        $eventArgument = new KeenEvent('A Title', ['key' => 'value']);
        $event = KeenEvent::fromArguments([$eventArgument]);

        $this->assertInstanceOf(KeenEvent::class, $event);
        $this->assertEquals('A Title', $event->keenTitle());
        $this->assertEquals('value', $event->keenData()['key']);
    }

    public function test_title_and_data_are_set()
    {
        $event = new KeenEvent('A Title', ['key' => 'value']);
        $this->assertEquals('A Title', $event->keenTitle());
        $this->assertEquals('value', $event->keenData()['key']);
    }

    public function test_event_will_sent()
    {
        KeenIO::fake();

        $event = new KeenEvent('Queued Event', ['key' => 'value']);

        KeenIO::addEvent($event);

        KeenIO::assertSent('Queued Event');
    }

    public function test_subclass_of_event_and_implementation_of_should_queue_will_queue()
    {
        KeenIO::fake();

        $event = new class('Event Title', ['key' => 'value']) extends KeenEvent implements ShouldQueue {};

        KeenIO::addEvent($event);

        KeenIO::assertQueued('Event Title');
    }

    public function test_base_event_will_queue_when_set()
    {
        KeenIO::fake();

        $event = (new KeenEvent('Queued Event', ['key' => 'value']))->queue();

        KeenIO::addEvent($event);

        KeenIO::assertQueued('Queued Event');
    }
    
    public function test_data_enrichment_enrichment()
    {
        $event = new KeenEvent('A Title', ['key' => 'value']);
      
        $fluentEvent = $event->enrichDatetime('timestamp', 'timestamp_info')
              ->enrichIPAddress('ip_address', 'ip_geo_info')
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
