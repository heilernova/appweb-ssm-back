<?php

use HNova\Rest\req;
use HNova\Rest\router;

router::get('/cases', fn() => require __DIR__ . '/cases-get-all.php');

router::get('/data', fn() => require __DIR__ . '/get-data.php');