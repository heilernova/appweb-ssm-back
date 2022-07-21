<?php

use HNova\Db\db;
use HNova\Rest\res;

$token = apache_request_headers()['access-token'] ?? null;

if ( $token ){
    $data = db::pull()->query("SELECT t1.* FROM tb_users_access t1 INNER JOIN tb_users t2 on t2.user = t1.id WHERE token = ?", [ $token ])->rows()[0] ?? null;

    if ( is_null($data) ) return res::sendStatus(401);

    $_ENV['app-user'] = $data;
    $_ENV['app-token'] = $token;
}

return null;