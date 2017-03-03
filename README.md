# Colibri Parameters Reader 🍓

## Usage

#### examples

```php
<?php

include_once '../vendor/autoload.php';

$config     = new Dez\Config\Adapter\NativeArray('./app.php');

$config->get('app')->get('path')->get('static');
$config['app']['path']['base'];
$config->app->path->base;
$config->app['path']->get('static');

$appJson    = $config['app']->toJSON();
$pathArray  = $config->app['path']->toArray();
```

#### using adapters

```php
<?php

include_once '../vendor/autoload.php';

$config     = new Dez\Config\Adapter\NativeArray('./_config.php');
$configJson = new Dez\Config\Adapter\Json('./_config.json');
```

#### using static method factory

```php
<?php

use Dez\Config\Config;
include_once '../vendor/autoload.php';

// from ini file
$config1    = Config::factory('./_config.ini');
// from native php file
$config2    = Config::factory('./_config.php');
// from json file
$config3    = Config::factory('./_config.json');
// from native php array
$config4    = Config::factory([
    'app' => [
        'site'  => 'test.com',
        'path'  => [
            'static'    => '/assets',
            'base'      => '/'
        ]
    ]
]);
```

#### merge config objects

```php
<?php

use Dez\Config\Config;
include_once '../vendor/autoload.php';

$config         = new Dez\Config\Adapter\NativeArray('./connection.php');
$configIni      = Config::factory('./app.ini');
$configJson     = new Dez\Config\Adapter\Json('./site-setting.json');

$globalConfig   = $config->merge($configIni)->merge($configJson);
```

#### extra methods

```php
<?php

include_once '../vendor/autoload.php';

$config         = new Dez\Config\Adapter\NativeArray('./connection.php');

$config->toArray();
$config->toJSON();
$config->toObject();
```
