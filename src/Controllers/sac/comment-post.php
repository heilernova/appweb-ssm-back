<?php

use App\app;
use HNova\Db\db;
use HNova\Rest\req;
use HNova\Rest\res;

$user_id = app::userID();
$case_id = req::params()->id;
$comment = req::body();


$data = [
    'case' => (int)$case_id,
    'user' => (int)$user_id,
    'content' => $comment
];

// $ok = db::pull()->insert($data, 'tb_sac_cases_comments', '*')->rows()[0] ?? null;
$ok = db::pull()->query('INSERT INTO tb_sac_cases_comments(`case`, user, content) VALUES(:case, :user, :content) returning *', $data)->rows()[0] ?? null;
if ( $ok ){
    $ok['user'] = ['id' => $ok['user'], 'name' => app::userName() ];
    return $ok;
}

return res::sendStatus(500);