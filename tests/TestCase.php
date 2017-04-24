<?php

namespace Sitruc\KeenIO\Test;

use Sitruc\KeenIO\Facades\KeenIO;
use Sitruc\KeenIO\KeenServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        
        $app['config']->set('database.default', 'mysql');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [KeenServiceProvider::class];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'KeenIO' => KeenIO::class,
        ];
    }
}
