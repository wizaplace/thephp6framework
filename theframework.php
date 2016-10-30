<?php

/* -----------------------------------------------------------------------------*/
/*                                 THEPHP6FRAMEWORK                             */
/* -----------------------------------------------------------------------------*/

// FRAMEWORK CORE
function run(array $middlewares)
{
    $next = function () {};
    foreach (array_reverse($middlewares) as $middleware) {
        $next = function () use ($middleware, $next) {
            $middleware($next);
        };
    }
    $next();
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
