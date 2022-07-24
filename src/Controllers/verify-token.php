<?php

use HNova\Db\db;
use HNova\Rest\res;

$token = apache_request_headers()['access-token']   ?? null;
// return $token;

if ( $token ){
    $data = db::pull()->query("SELECT t1.*, concat(t2.name, ' ', t2.lastName) as 'name' FROM tb_users_access t1 INNER JOIN tb_users t2 on t1.user = t2.id WHERE t1.token = ?", [ $token ])->rows()[0] ?? null;

    if ( $data ){

        $_ENV['app-user']['id'] = $data['user'];
        $_ENV['app-user']['name'] = $data['name'];
        $_ENV['app-token'] = $token;
        return null;
    }

}

return res::sendStatus(401);