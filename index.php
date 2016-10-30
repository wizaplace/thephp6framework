<?php

require_once __DIR__ . '/theframework.php';

run(array(
    'security_middleware',
    function ($next) {
        echo 1;
    },
));
