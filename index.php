<?php

    require_once dirname(__FILE__) . '/theframework.php';

test(array(
        '$_GET["foo"] = "bar\'bar"; $next();',
        'security_middleware(); $next();',
        'echo "1!\n"; $next(); echo "3!\n";',
        'echo "2!\n"; $next();',
        'echo $_GET["foo"] . "\n"; $next();',
    ))

    ;
