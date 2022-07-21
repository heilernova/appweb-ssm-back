<?php

use HNova\Rest\router;

router::get('/dni-types', fn() => require __DIR__ . '/dni-type-get.php');
router::post('/dni-types', fn() => require __DIR__ . '/dni-type-post.php');
router::put('/dni-types', fn() => require __DIR__ . '/dni-type-put.php');

router::get('/:id', fn() => require __DIR__ . '/person-get.php');
router::post('/', fn() => require __DIR__ . '/person-post.php');
router::put('/:id', fn() => require __DIR__ . '/person-put.php');