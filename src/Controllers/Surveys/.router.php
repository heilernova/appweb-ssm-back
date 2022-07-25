<?php

use HNova\Rest\router;

router::get('/report', fn() => require __DIR__ . '/report-get.php');