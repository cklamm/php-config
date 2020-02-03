# PHP Config

This small library makes it easy to read configuration variables from PHP files.

## Contents

* [Installation](#installation)
* [ConfigFile](#configfile)
* [ConfigFolder](#configfolder)

## Installation

The library can be installed via [Composer](https://getcomposer.org).

```
composer require cklamm/config
```

## ConfigFile

This class reads configuration variables from a single PHP file, which must return an associative array. Consider the following example.

```php
<?php // config.php

return [
    'foo' => 'bar',
    'array' => ['a', 'b', 'c'],

    'db.driver' => 'mysql',
    'db.host' => 'localhost',
    'db.port' => 3306,

    'log.debug.db' => '*',
    'log.debug.file' => '*',
    'log.prod.db' => 'error,warning,info',
    'log.prod.file' => 'error,warning,info',
];
```

The file name is passed to the constructor of `ConfigFile`.

The method `get($name)` is used to access the configuration variables.

* If `$name` equals `*`, the whole array is returned.
* If `$name` exists as a key, the corresponding value is returned.
* If `$name` ends with `.*`, an array is returned containing all entries whose key starts with `$name` (minus the asterisk). The `$name` part is removed from the keys. If there are no matching keys, the returned array will be empty.
* Else `null` is returned.

```php
<?php

use cklamm\Config\ConfigFile;

$config = new ConfigFile('config.php');

$config->get('foo');            // 'bar'
$config->get('array');          // ['a', 'b', 'c']
$config->get('undefined');      // null

$config->get('db.driver');      // 'mysql'
$config->get('log.prod.db');    // 'error,warning,info'

$config->get('*');              // all entries
$config->get('db.*');           // all entries whose key starts with db.
$config->get('log.prod.*');     // all entries whose key starts with log.prod.
```

## ConfigFolder

This class reads configuration variables from a folder containing multiple PHP files. Each file must return an associative array. For example, we could have the following two files in a `config` folder.

```php
<?php // config/db.php

return [
    'driver' => 'mysql',
    'host' => 'localhost',
    'port' => 3306,
];
```

```php
<?php // config/log.php

return [
    'debug.db' => '*',
    'debug.file' => '*',
    'prod.db' => 'error,warning,info',
    'prod.file' => 'error,warning,info',
];
```

The folder name is passed to the constructor of `ConfigFolder`.

The method `get($name)` is used to access the configuration variables. The part of `$name` before the first `.` corresponds to the file name.

* If `$name` contains no `.`, `null` is returned.
* If no corresponding file exists, `null` is returned.
* Otherwise it behaves similarly to the `get` method of `ConfigFile`.

```php
<?php

use cklamm\Config\ConfigFolder;

$config = new ConfigFolder('config');

$config->get('db.driver');      // 'mysql'
$config->get('log.prod.db');    // 'error,warning,info'

$config->get('*');              // null
$config->get('db');             // null
$config->get('db.*');           // all entries from config/db.php
$config->get('log.prod.*');     // all entries from config/log.php
                                //  whose key starts with prod.
```
