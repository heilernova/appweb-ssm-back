<?php

use HNova\Db\db;
use HNova\Rest\req;
use HNova\Rest\res;

$type = req::params()->survey;

$table = match( $type ){
    'eps' => 'tb_survey_eps',
    'ips' => 'tb_survey_ips',
    'medicine' => 'tb_survey_medicine',
    'laboratory' => 'tb_survey_laboratory',
    default => null
};

if ( $table ){

    $params = req::body();

    return db::pull()->insert($params, $table)->rowCount > 0;

}else{

    return res::text("Typo de encuesta invalido")->status(401);
}