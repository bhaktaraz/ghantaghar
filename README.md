# Ghantaghar

A simple PHP API extension for Nepali DateTime. [http://bhaktaraz.com.np](http://bhaktaraz.com.np)

```php
printf("अहिले को समय :: %s", Ghantaghar::now());
```

## Installation

### With Composer

```
$ composer require bhaktaraz/ghantaghar
```

```json
{
    "require": {
        "bhaktaraz/ghantaghar": "dev-master"
    }
}
```

```php
<?php
require 'vendor/autoload.php';

use Bhaktaraz\Ghantaghar\Ghantaghar;

printf("अहिले को समय :: %s", Ghantaghar::now());
```

<a name="install-nocomposer"/>
### Without Composer

Why are you not using [composer](http://getcomposer.org/)? Download [Ghantaghar.php](https://github.com/bhaktaraz/ghantaghar/blob/master/src/Ghantaghar.php) from the repo and save the file into your project path somewhere.

```php
<?php
require 'path/to/Ghantaghar.php';

use Bhaktaraz\Ghantaghar\Ghantaghar;

printf("अहिले को समय :: %s", Ghantaghar::now());
```
