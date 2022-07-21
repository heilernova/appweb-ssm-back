<?php

use HNova\Rest\router;

router::get('/interviewer', fn() => require __DIR__ . '/interviewer-get.php' );

router::post('/:survey', fn() => require __DIR__ . '/surverys-post.php');