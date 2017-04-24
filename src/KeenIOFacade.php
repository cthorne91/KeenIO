<?php

namespace Sitruc\KeenIO;

use Illuminate\Support\Facades\Facade;
use Sitruc\KeenIO\Test\Fakes\KeenIOFake;

class KeenIOFacade extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return void
     */
    public static function fake()
    {
        static::swap(new KeenIOFake);
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'keenio';
    }
}

