<?php

use HNova\Rest\router;

router::get('/excel', fn() => require __DIR__ . '/excel-get.php');