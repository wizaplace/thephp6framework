<?php

    require_once dirname(__FILE__) . '/theframework.php';

test(array(
        '$_GET["foo"] = "bar\'bar"; call_user_func($next);',
        'security_middleware(); call_user_func($next);',
        'echo "1!\n"; call_user_func($next); echo "3!\n";',
        'echo "2!\n"; call_user_func($next);',
        'echo $_GET["foo"] . "\n"; call_user_func($next);',
    ))

    ;
