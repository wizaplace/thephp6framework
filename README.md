The one and only PHP 6 framework.

## Why?

Because PHP 6 is the future, but not too much the future at the same time!

Oh and also this framework is a very simple introduction to **PHP middlewares**. It shows a very basic implementation of a framework based on middlewares without PSR-7 or even objects representing the request or the response.

## Does it work on PHP 5

No.

## Does it work on PHP 7

No.

## Does it work on PHP 6?

YES!

## Demo

A demo is included in this package ([`index.php`](index.php)), just run this command and visit [http://localhost:8000/index.php](http://localhost:8000/index.php)

```
docker-compose up
```

## Deployment in production

Compiling PHP 6 isn't easy, fortunately you can now deploy it straight to production thanks to this Docker image: [`wizaplace/php-6-apache`](https://github.com/wizaplace/docker-php-6-apache).

Have a look at our [docker-compose.yml](docker-compose.yml) to see how we use it.

## Introduction

A traditional middleware looks like this:

```php
function (ServerRequestInterface $request, callable $next) {
    // do something before the next middleware

    $response = $next($request);

    // do something after the next middleware

    return $response;
}
```

In thephp6framework, in order to have maximum simplicity and maximum global state (:p) there are no objects to represent the request and the response.

The request is retrievable via the native PHP way:

- global variables like `$_GET`, `$_POST`, `$_SERVER`, …
- the raw input in the stream `php://input`

The response can be emitted via the native PHP way:

- `echo '...'` to output the body ([`ob_start()`](http://php.net/manual/fr/function.ob-start.php) and similar functions to buffer the output)
- [`header()`](http://php.net/manual/fr/function.header.php) to set headers

Because of that, a middleware looks like this:

```php
function ($next) {
    // do something before the next middleware

    $next();

    // do something after the next middleware
}
```

## Request pre-processor

Even though the request is not an object, you can still write a middleware that will pre-process it (modify it) before invoking the next middleware:

```php
function security_middleware($next) {
    // Secure the application BIG TIME by replicating PHP magic quotes
    if (isset($_GET)) {
        foreach ($_GET as &$value) {
            $value = addslashes($value);
        }
    }
    if (isset($_POST)) {
        foreach ($_POST as &$value) {
            $value = addslashes($value);
        }
    }

    $next();
}
```

## Response post-processor

Even though the response is not an object, you can still write a middleware that will modify the response returned by the next middleware:

```php
function cloud_to_butt($next) {
    // You could also use the framework's capture() function
    ob_start();
    $next();
    $html = ob_get_contents();
    ob_end_clean();

    $html = str_replace('the cloud', 'my butt', $html);

    echo $html;
}
```

## Usage

### Router

To build a simple application with different routes, you can use the `router()` function:

```php
require_once __DIR__ . '/theframework.php';

$app = router(array(
    '/' => function () {
        echo 'The home page';
    },
    '/about' => function () {
        echo 'The about page';
    },
));

$app();
```

### Pipe

You can pipe middlewares one after another using the pipe:

```php
$app = pipe(array(
    function ($next) {
        echo 'Welcome ';
        $next();
    },
    function () {
        echo 'in the cloud!';
    },
));

$app();
```

### Advanced architecture

The great thing about thephp6framework is that everything is a middleware:

- the router is a middleware
- the pipe is a middleware
- controllers are middlewares too

Considering that, you can nest routers in pipes in controllers in pipes in routers…

For example, if you want to add middlewares before the router, simply use the pipe:

```php
$app = pipe(array(
    'security_middleware',
    router(array(
        '/' => function () {
            echo 'Hello world!';
        },
    )),
));

$app();
```

### The `capture()` function

The `capture()` function is a little helper from the framework around output buffering. Instead of this:

```php
ob_start();
echo 'Hello world!';
$output = ob_get_contents();
ob_end_clean();
```

You can write this:

```php
$output = capture(function () {
    echo 'Hello world!';
});
```

That means that if you want to capture the output of the next middleware, you can simply do this (because `$next` is a callable):

```php
$html = capture($next);
```

## TODO

- [moar middlewares!](https://github.com/wizacha/thephp6framework/blob/master/theframework.php#L65-L65)
- allow placeholders in the router (regex with `preg_match()`?)

## Learn more

This framework is meant as a very simple introduction to PHP middlewares. If you are interested to learn more you can read [this great article](https://mwop.net/blog/2015-01-08-on-http-middleware-and-psr-7.html) and have a look at [Zend Expressive](https://zendframework.github.io/zend-expressive/) or [Slim](http://www.slimframework.com/).
