<?php

/* -----------------------------------------------------------------------------*/
/*                                 THEPHP6FRAMEWORK                             */
/* -----------------------------------------------------------------------------*/

// FRAMEWORK CORE
function test(array $middlewares)
{
    $next = 'nothing';
    foreach (array_reverse($middlewares) as $middleware) {
        $next = array(new LazyNext($middleware, $next), 'run');
    }
    call_user_func($next);
}

class LazyNext
{
    function __construct($middleware, $next)
    {
        $this->middleware = $middleware;
        $this->next = $next;
    }
    function run()
    {
        // Put the variable in the local scope so that it's available in the middleware
        $next = $this->next;
        // TODO replace eval with Closures if they are ever implemented in PHP
        eval($this->middleware);
    }
}

// Does nothing
function nothing() {}


/* -----------------------------------------------------------------------------*/
/*                              MIDDLEWARE MARKETPLACE                          */
/* -----------------------------------------------------------------------------*/
/*            Edit this file and add your open source middlewares!!! :)         */
/* -----------------------------------------------------------------------------*/

// Secures the application BIG TIME
// @see http://php.net/manual/en/security.magicquotes.php
function security_middleware()
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
}
