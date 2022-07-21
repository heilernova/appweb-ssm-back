<?php

use HNova\Rest\router;

router::get('/cases', fn() => require __DIR__ . '/cases-get-all.php');