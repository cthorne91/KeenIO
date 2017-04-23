<?php

namespace Sitruc\KeenIO;

use Sitruc\KeenIO\KeenIO;
use KeenIO\Client\KeenIOClient;
use Sitruc\KeenIO\KeenIONull;
use Illuminate\Support\ServiceProvider;

class KeenServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('keenio', function () {
            if (config('services.keenio.enabled') == true) {
                return new KeenIO(KeenIOClient::factory([
                    'projectId' => config('services.keenio.project_id'),
                    'writeKey'  => config('services.keenio.write_key'),
                    'readKey'   => config('services.keenio.read_key'),
                ]));
            }

            return new KeenIONull;
        });
    }
}
