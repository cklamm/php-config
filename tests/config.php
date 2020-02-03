<?php

return [
    '' => 'empty',
    'foo' => 'bar',
    'array' => ['a', 'b', 'c'],

    'db.driver' => 'mysql',
    'db.host' => 'localhost',
    'db.port' => 3306,

    'log.debug.db' => '*',
    'log.debug.file' => '*',
    'log.prod.db' => 'error,warning,info',
    'log.prod.file' => 'error,warning,info',
];
