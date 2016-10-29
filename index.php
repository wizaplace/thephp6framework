<?php

require_once dirname(__FILE__) . '/theframework.php';

run([
    '$_GET["foo"] = "bar\'bar"; call_user_func($next);',
    'security_middleware(); call_user_func($next);',
    'echo "1!\n"; call_user_func($next);',
    'echo "2!\n"; call_user_func($next);',
    'echo $_GET["foo"] . "\n"; call_user_func($next);',
    'echo "length: " . strlen("👀") . "\n"; call_user_func($next);',
]);
