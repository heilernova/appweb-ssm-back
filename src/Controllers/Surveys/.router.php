<?php

use HNova\Rest\router;

router::get('/report', fn() => require __DIR__ . '/report-get.php');

router::get('/export', fn() => require __DIR__ . '/export.php');