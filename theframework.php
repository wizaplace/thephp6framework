<?php

/* -----------------------------------------------------------------------------*/
/*                                 THEPHP6FRAMEWORK                             */
/* -----------------------------------------------------------------------------*/

/**
 * Create a pipe middleware.
 *
 * @param array $middlewares List of middlewares.
 * @param callable|null $next
 * @return callable The middleware created.
 */
function pipe(array $middlewares, $next = null)
{
    // next can be null so that this can be used simply as the root function for the application
    $next = $next ? $next : 'last_handler';

    return function () use ($middlewares, $next) {
        foreach (array_reverse($middlewares) as $middleware) {
            $next = function () use ($middleware, $next) {
                $middleware($next);
            };
        }
        $next();
    };
}

/**
 * Create a router middleware.
 *
 * @param array $middlewares Map of URL => middleware.
 * @param callable|null $next
 * @return callable The middleware created.
 */
function route(array $middlewares, $next = null)
{
    // next can be null so that this can be used simply as the root function for the application
    $next = $next ? $next : 'last_handler';

    return function () use ($middlewares, $next) {
        $url = $_SERVER['REQUEST_URI'];

        if (isset($middlewares[$url])) {
            $middlewares[$url]($next);
            return;
        }

        // No route was configured for this request
        $next();
    };
}

/**
 * Last handler to call when no middleware wants to generate a response.
 */
function last_handler()
{
    http_send_status(404);
    echo 'Page not found';
}


/* -----------------------------------------------------------------------------*/
/*                              MIDDLEWARE MARKETPLACE                          */
/* -----------------------------------------------------------------------------*/
/*            Edit this file and add your open source middlewares!!! :)         */
/* -----------------------------------------------------------------------------*/

// Secures the application BIG TIME
// @see http://php.net/manual/en/security.magicquotes.php
function security_middleware($next)
{
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
    if (isset($_SESSION)) {
        foreach ($_SESSION as &$value) {
            $value = addslashes($value);
        }
    }

    $next();
}
