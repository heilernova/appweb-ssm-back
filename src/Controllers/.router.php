<?php

use HNova\Db\db;
use HNova\Rest\api;
use HNova\Rest\root;
use HNova\Rest\router;

router::use(function(){

    $pdo = api::getConfig()->databases->getPDO('db');
    db::setPDO($pdo);

});

router::use('/migrations', fn()=> require __DIR__ . '/migrations/.router.php');

router::post( '/auth', fn() => require __DIR__ . '/auth.php' );

router::use('/satisfaction-survey', fn() => require __DIR__ . '/Surveys/.router.public.php' );

router::use( fn() => require __DIR__ . '/verify-token.php' );

router::use('/surveys', fn() => require __DIR__ . '/Surveys/.router.php');

router::use('/sac', fn() => require __DIR__ . '/sac/.router.php');

router::use('/persons', fn() => require __DIR__ . '/persons/.index.php');