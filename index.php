<?php

require __DIR__ . '/vendor/autoload.php';

use HNova\Rest\apirest;

$app = apirest::createServer();
$app->use('/', fn() => require __DIR__ . '/src/Controllers/.router.php');
$app->run();