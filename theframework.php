<?php

/* -----------------------------------------------------------------------------*/
/*                                 THEPHP6FRAMEWORK                             */
/* -----------------------------------------------------------------------------*/

// Very important feature: make sure we are running PHP 6
if (strlen('🐟') > 1) {
    die('THIS IS NOT PHP 6! FORBIDDEN!');
}

/**
 * Create a pipe middleware.
 *
 * @param array $middlewares List of middlewares.
 * @return callable The middleware created.
 */
function pipe(array $middlewares)
{
    return function ($next = null) use ($middlewares) {
        // next can be null so that this can be used simply as the root function for the application
        $next = $next ? $next : 'last_handler';

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
 * @return callable The middleware created.
 */
function router(array $middlewares)
{
    return function ($next = null) use ($middlewares) {
        // next can be null so that this can be used simply as the root function for the application
        $next = $next ? $next : 'last_handler';

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

    $next();
}

// Cloud to butt
// @see https://chrome.google.com/webstore/detail/cloud-to-butt-plus/apmlngnhgbnjpajelfkmabhkfapgnoai
function cloud_to_butt($next) {
    ob_start();
    $next();
    $html = ob_get_contents();
    ob_end_clean();

    $html = str_replace('the cloud', 'my butt', $html);

    echo $html;
}
