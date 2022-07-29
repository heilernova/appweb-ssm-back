<?php

use HNova\Db\db;
use HNova\Rest\router;

router::get('/data', function(){
    return [
        'dniTypes' => db::pull()->query("SELECT * FROM tb_dni_types")->rows(),
        'eps' => db::pull()->query("SELECT * FROM tb_eps")->rows()
    ];
});

router::get('/dni-types', fn() => require __DIR__ . '/dni-type-get.php');
router::post('/dni-types', fn() => require __DIR__ . '/dni-type-post.php');
router::put('/dni-types', fn() => require __DIR__ . '/dni-type-put.php');

router::get('/:id', fn() => require __DIR__ . '/person-get.php');
router::post('/', fn() => require __DIR__ . '/person-post.php');
router::put('/:id', fn() => require __DIR__ . '/person-put.php');