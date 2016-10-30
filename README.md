The one and only PHP 6 framework.

## Why?

Because PHP 6 rocks!

## Demo

A demo is included in this package ([`index.php`](index.php)), just run this command and visit http://localhost:8000/index.php

```
docker-compose up
```

## Usage

Here is a short example:

```php
require_once __DIR__ . '/theframework.php';

run(array(
    function ($next) {
        echo 'Hello';
        $next();
    },
    function ($next) {
        echo ' World!';
    },
));
```

This will display "Hello world!".
