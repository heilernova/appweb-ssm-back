<?php
/**
 * Autentcicacion del usuario
 */

use HNova\Db\Pull;
use HNova\Rest\req;

$pull = new Pull();

$username = req::body()->username;
$password = req::body()->password;

$field = str_contains($username, '@') ? 'email' : 'username';

$slq = "SELECT t1.*, COUNT(t2.id) AS 'access' FROM tb_users t1 LEFT JOIN tb_users_access t2 on t2.user = t1.id where $field = ?";

$user = $pull->query($slq, [ $username ])->rows()[0] ?? null;

if ( $user ){

    if ( $user['disale'] == 1 ){
        return [ 'message' => 'Tu usuario ya no tiene acceso al sistema' ];
    }

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
        'user' => $user->id,
        'token' => $token,
        'device' => req::device()
    ], 'tb_users_device');

    return [
        'access' => [
            'token' => $token,
            'user' => [
                'name' => $user['name'],
                'lastName' => $user['lastName'],
                'rule' => $user['rule']
            ]
        ]
    ];

}else{
    return [ 'message' => 'Usuario no registrado' ];
}