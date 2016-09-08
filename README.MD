This is package for use [Selectel](https://selectel.com/) as CDN service for Laravel 5.*

Add to config/filesystems.php in "disks" array:
```php
    'selectel' => [
        'driver'    => 'selectel',
        'username'  => 'container-username',
        'key'       => 'container-password',
        'container' => 'container-name',
        'endpoint'  => 'https://auth.selcdn.ru',
        'region'   => 'aws-global',
    ],
```
set "default", or "cloud" selectel storage.

Add to config/app.php in service provider section:
```php
Reg2005\LaravelSelectel\SelectelServiceProvider::class,
```

And use: https://laravel.com/docs/5.3/filesystem