<?php

use HNova\Rest\router;

router::get('/:name', fn() => require __DIR__ . '/files-get.php');

router::delete('/:name', fn() => require __DIR__ . '/file-delete.php');

router::post('/', fn() => require __DIR__ . '/file-post.php');