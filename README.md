# A convenient wrapper around the Keen.io PHP SDK for Laravel

Using this package you can send events to keen.io in laravel elegance. Here are a few examples from basic to elegant.

The most basic example, using the facade which accepts both a KeenEvent or the name and data directly.
```php
use KeenIO;

KeenIO::addEvent('New Event', ['key' => 'value']);
```

Or pass a KeenEvent
```php
use KeenIO;
use Sitruc\KeenIO\KeenEvent

$event = new KeenEvent('New Event', ['key' => 'value']);

KeenIO::addEvent($event);
```

If you prefer, you can send the event directly.
```php

use Sitruc\KeenIO\KeenEvent;

$event = new KeenEvent('New Event', ['key' => 'value']);

$event->send();

```


Queuing events.

```php

use Sitruc\KeenIO\KeenEvent;

$event = new KeenEvent('New Queued Event', ['key' => 'value']);

$event->queued()->send();
```

Use keen.io's data enrichment.

```php

use Sitruc\KeenIO\KeenEvent;

$event = new KeenEvent('New Event', ['key' => 'value']);

//Enriches keen's default keen.timestamp value into enriched_timestamp
$event->enrichDatetime();

$event->enrichDatetime('some.other.timestamp.source', 'new.enriched.location');

$event->send();
```

Methods are fluent so the above example can become.

```php

use Sitruc\KeenIO\KeenEvent;

$event = new KeenEvent('Keen Event', ['key' => 'value']);

$event->enrichDatetime()
      ->enrichDatetime('some.other.timestamp.source', 'new.enriched.location')
      ->send();
```

The following enrichment values are accepted.
You can read more about data enrichment, also known as 'Add Ons' [in the keen.io documentation](https://keen.io/docs/api/#ip-to-geo-parser)

```php
public function enrichDatetime($source = 'keen.timestamp', $destination = 'enriched_timestamp')

public function enrichIPAddress($source, $destination = 'ip_geo_info')

public function enrichUserAgent($source, $destination = 'parsed_user_agent')

public function enrichURL($source, $destination)

public function enrichReferrer($referrer_url_input, $page_url_input, $destination)
```

Subclassing KeenEvent can be even more powerful.

Behind the scenes this packages uses laravel's dispatch handler. This means you can implement the `ShouldQueue` interface and dispatch onto specific queues just like you would any other job.

Here is an example of reporting a registration event on a keenio queue with enriched created_at and upgrade_date.
Simple and elegant!

```php
<?php

namespace App\Http\Controllers;

use App\KeenEvents\NewRegistration;

class UserController
{
    public function registerUser()
    {
        //Register the user.
        NewRegistration::from($user)->send();
    }
}
```
```php
<?php

namespace App\KeenEvents;

use Sitruc\KeenIO\KeenEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewRegistration extends KeenEvent implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    
    protected $keenTitle = 'New Registration';
    
    protected $user;
  
    public function __construct($user)
    {
        $this->user = $user;

        $this->onQueue('keenio')
             ->enrichDatetime()
             ->enrichDatetime('upgrade_date', 'enriched_upgrade_date');
    }

    public static function from($user)
    {
        return new static($user);
    }

    public function keenData()
    {
        return [
            'account_type' => $this->user->accountType,
            'upgrade_date' => $this->user->upgradeDate->toAtomString(),
        ];
    }
}
```

## Install
This package can be installed through Composer.

``` bash
composer require sitruc/keenio
```

You must install this service provider.

```php
// config/app.php
'providers' => [
    ...
    Sitruc\KeenIO\KeenServiceProvider::class,
    ...
];
```

This package also comes with a facade, which provides an easy way to call the the class.

```php
// config/app.php
'aliases' => [
    ...
    'KeenIO' => Sitruc\KeenIO\Facades\KeenIO::class,
    ...
];
```

This package requires a you to add your `project_id` `write_key` `read_key` and `enabled` to the `services` config file.
```php
// config/services.php
<?php
return [
    ...
    'keenio' => [
        'project_id' => env('KEENIO_PROJECT_ID'),
        'write_key'  => env('KEENIO_WRITE_KEY'),
        'read_key'   => env('KEENIO_READ_KEY'),
        'enabled'    => env('KEENIO_ENABLED'),
    ],
    ...
]
```

the `enabled` flag is useful if you want to shut off keen reporting in certain environments.

## Testing

Run the tests with:

``` bash
vendor/bin/phpunit
```
or
```bash
composer test
```

## Security

If you discover any security related issues, please email cthorne@me.com instead of using the issue tracker.

## Credits

- [Curtis Thorne](https://github.com/cthorne91)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
