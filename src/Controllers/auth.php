<?php
/**
 * Autentcicacion del usuario
 */

use HNova\Db\Pull;
use HNova\Rest\req;
use HNova\Rest\res;

$pull = new Pull();

$username = req::body()->username;
$password = req::body()->password;

// return res::text(req::body())->status(500);

$field = str_contains($username, '@') ? 'email' : 'username';

$slq = "SELECT t1.*, (select count(*) from tb_users_access where user = t1.id ) AS 'access' FROM tb_users t1  where $field = ?";
// return $slq;
$user = $pull->query($slq, [ $username ])->rows()[0] ?? null;

// return $user;

if ( $user ){

    if ( $user['disable'] == 1 ){
        return [ 'message' => 'Tu usuario ya no tiene acceso al sistema' ];
    }

    // return res::text(json_encode($user))->status(404);
    if ( $user['access'] == 3 ){
        // Eliminamos un acceso
        $sql = "SELECT id FROM tb_users_access WHERE user = ? order by device";
        $result = $pull->query($slq, [ $user['id'] ])->rows()[0] ?? null;

        if ( $result ){
            $pull->query("DELETE FROM tb_users_access WHERE id = ?", [ $result['id'] ]);
        }
    }

    $token_invalid = true;

    while ( $token_invalid ){
        $longitud = 50;
        $token = bin2hex(random_bytes(($longitud - ($longitud % 2)) / 2));
        $token_invalid = $pull->query("SELECT * FROM tb_users_access WHERE token = ?", [ $token ])->rowCount > 0;
    }   

    $pull->insert([
        'user' => $user['id'],
        'token' => $token,
        'device' => req::device()
    ], 'tb_users_access');

    return [
        'access' => [
            'token' => $token,
            'user' => [
                'name' => strtolower( $user['name'] ),
                'lastName' => strtolower( $user['lastName'] ),
                'rule' => $user['rule']
            ]
        ]
    ];

}else{
    return [ 'message' => 'Usuario no registrado' ];
}