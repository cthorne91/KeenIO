<?php

namespace Sitruc\KeenIO\Test;

use Mockery;
use Sitruc\KeenIO\KeenIO;
use Sitruc\KeenIO\KeenIONull;
use Sitruc\KeenIO\KeenServiceProvider;

class ServiceProviderTest extends TestCase 
{
    public function test_service_provider_can_be_initialized()
    { 
        $app = Mockery::mock(\Illuminate\Foundation\Application::class);

        $provider = new KeenServiceProvider($app);

        $this->assertNotNull($provider);
    }

    public function test_keen_io_enabled_config_property_works()
    {
        $this->app['config']->set('services.keenio.enabled', false);

        $this->assertFalse(config('services.keenio.enabled'));

        $this->assertInstanceOf(KeenIONull::class, $this->app->make('keenio'));
    }

    public function test_keen_io_instance_can_be_initialized()
    {
        $this->app['config']->set('services.keenio.enabled', true);
        $this->app['config']->set('services.keenio.project_id', 'project_id_123');
        $this->app['config']->set('services.keenio.write_key', 'write_key_123');
        $this->app['config']->set('services.keenio.read_key', 'read_key_123'); 

        $this->assertTrue(config('services.keenio.enabled'));
        $this->assertEquals('project_id_123', config('services.keenio.project_id'));
        $this->assertEquals('write_key_123', config('services.keenio.write_key'));
        $this->assertEquals('read_key_123', config('services.keenio.read_key'));

        $instance = $this->app->make('keenio');

        $this->assertEquals(KeenIO::class, get_class($instance));
        $this->assertEquals('project_id_123', $instance->getProjectId());
        $this->assertEquals('write_key_123', $instance->getWriteKey());
        $this->assertEquals('read_key_123', $instance->getReadKey());        
    }
}
