<?php

require_once __DIR__ . '/theframework.php';

$app = pipe(array(

    'security_middleware',

    'cloud_to_butt',

    // Middleware to center everything!
    function ($next) {
        echo '<center>';
        $next();
        echo '</center>';
    },

    // Footer
    function ($next) {
        $next();
        echo '<p>Powered by PHP 6</p>';
        $len = strlen('🐟');
        echo "<code>strlen('🐟') === $len</code>";
    },

    router(array(
        '/' => function () {
            echo '<h1>Welcome in the cloud</h1>';
        },
    )),
));

$app();
