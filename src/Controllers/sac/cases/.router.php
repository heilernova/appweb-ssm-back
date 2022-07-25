<?php

use HNova\Rest\router;

router::get('/', fn() => require __DIR__ . '/cases-get-all.php');

router::post('/', fn() => require __DIR__ . '/cases-post.php');

router::use('/:caseId/comments', fn() => require __DIR__ . '/comments/.router.php');