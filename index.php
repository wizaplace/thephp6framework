<?php

require_once __DIR__ . '/theframework.php';

$app = pipe(array(
    'security_middleware',
    route(array(
        '/' => function () {
            echo 1;
        }
    )),
));

$app();
