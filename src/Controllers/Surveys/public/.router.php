<?php

use HNova\Rest\router;

router::get('/data', fn() => require __DIR__ . '/data-get.php');

router::post('/', fn() => require __DIR__ . '/post.php');