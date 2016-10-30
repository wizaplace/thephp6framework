The one and only PHP 6 framework.

## Why?

Because PHP 6 rocks!

## Demo

A demo is included in this package ([`index.php`](index.php)), just run this command and visit http://localhost:8000/index.php

```
docker-compose up
```

## Usage

To build a simple application with different routes:

```php
require_once __DIR__ . '/theframework.php';

$app = route(array(
    '/' => function () {
        echo 'The home page';
    },
    '/about' => function () {
        echo 'The about page';
    },
));

$app();
```

If you want to add middlewares before the router, simply use the pipe:

```php
require_once __DIR__ . '/theframework.php';

$app = pipe(array(
    'security_middleware',
    route(array(
        '/' => function () {
            echo 'Hello world!;
        },
    )),
));

$app();
```
