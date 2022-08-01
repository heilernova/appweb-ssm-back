<?php

use HNova\Db\db;
use HNova\Rest\api;
use HNova\Rest\res;
use HNova\Rest\router;

router::get('/delete', function(){
    $ids = [
        385,
        487,
        657,
        691,
        692,
        693,
        694,
        695,
        696,
        697,
        698,
        699,
        700,
        710,
        723,
        844,
        910,
        911,
        926,
        1086,
        386,
        478,
        702,
        703,
        704,
        705,
        706,
        707,
        708,
        0635,
        636,
        637,
        638,
        639,
        804,
        1051,
        1108,
        474,
        760,
        789,
        812,
        862,
        863,
        920,
        922,
        923,
        935,
        1017,
        1054,
        1055,
        643,
        644,
        651,
        792,
        882,
        891,
        892,
        893,
        894,
        964,
    ];

    $con = "";

    foreach ( $ids as $id){
        $con .= " or id=$id";
    }
    $con = ltrim($con, ' or');

    $sql = "DELETE FROM tb_surveys_answers WHERE $con";
    $del = db::pull()->query($sql)->rowCount;

    return [
        count($ids),
        $del
    ];
});

router::use(function(){

    // "dataConnection": {
    //     "hostname": "sql549.main-hosting.eu",
    //     "username": "u204056831_ssm",
    //     "password": "P0|sdJF8HGi",
    //     "database": "u204056831_ssm"
    // },
    $ok = db::connect('mysql', 'sql549.main-hosting.eu', 'u204056831_ssm','u204056831_ssm', 'P0|sdJF8HGi');
    return $ok ? null : res::text("Error con la conexion DB Cloud")->status(500);
});

$fun_mi = function(){

    require __DIR__ . '/funs.php';


    $users = require __DIR__ . '/tb_01_users.php';
    $eps = require __DIR__ . '/tb_02_eps.php';
    $ips = require __DIR__ . '/tb_03_ips.php';
    $persons = require __DIR__ . '/tb_04_persons.php';
    $attentions = require __DIR__ . '/tb_05_cases_attentions.php';
    $cases = require __DIR__ . '/tb_06_cases.php';
    $comments = require __DIR__ . '/tb_07_cases_comments.php';
    $surveys = require __DIR__ . '/tb_08_surveys.php';


    unlink( __DIR__ . '/backout.sql');

    $file = fopen(__DIR__ . '/backout.sql', 'a+');
    fputs($file, "$users\n\n$eps\n\n$ips\n\n$persons\n\n$attentions\n\n$cases\n\n$comments\n\n$surveys");
    fclose($file);

};

router::get('/', $fun_mi);

router::get('/apply', function(){
    require __DIR__ . '/funs.php';


    $users = require __DIR__ . '/tb_01_users.php';
    $eps = require __DIR__ . '/tb_02_eps.php';
    $ips = require __DIR__ . '/tb_03_ips.php';
    $persons = require __DIR__ . '/tb_04_persons.php';
    $attentions = require __DIR__ . '/tb_05_cases_attentions.php';
    $cases = require __DIR__ . '/tb_06_cases.php';
    $comments = require __DIR__ . '/tb_07_cases_comments.php';
    $surveys = require __DIR__ . '/tb_08_surveys.php';


    unlink( __DIR__ . '/backout.sql');

    $file = fopen(__DIR__ . '/backout.sql', 'a+');
    fputs($file, "$users\n\n$eps\n\n$ips\n\n$persons\n\n$attentions\n\n$cases\n\n$comments\n\n$surveys");
    fclose($file);

    $pdo = api::getConfig()->databases->getPDO('db1');
    // db::setPDO($pdo);

    $pdo->query( file_get_contents(  __DIR__ . '/../../db.sql' ) );
    $pdo->query( file_get_contents( __DIR__ . '/backout.sql'));


    return true;
});