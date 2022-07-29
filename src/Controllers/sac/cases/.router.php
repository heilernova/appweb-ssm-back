<?php

use HNova\Rest\router;

router::get('/', fn() => require __DIR__ . '/cases-get-all.php');

router::post('/', fn() => require __DIR__ . '/cases-post.php');

router::use('/:caseId/comments', fn() => require __DIR__ . '/comments/.router.php');
router::get('/:caseId/files/:name', fn() => require __DIR__ . '/files.php');

router::use('/export', fn() => require __DIR__  . '/export/.router.php');