<?php

require_once __DIR__ . '/theframework.php';

$app = pipe(array(
    'security_middleware',
    'cloud_to_butt',
    router(array(
        '/' => function () {
            echo 'Welcome in the cloud';
        }
    )),
));

$app();
