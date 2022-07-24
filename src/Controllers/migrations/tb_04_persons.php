<?php

use HNova\Db\db;

$rows = db::pull()->query("SELECT * FROM tb_persons")->rows();

$rows = array_map(function($row){

    $row['name'] = strtoupper( $row['name'] );
    $row['lastName'] = strtoupper ( $row['lastName'] );
    $row['cellphones'] = [
        [
            'num' => $row['cellphone'],
            'note' => ''
        ]
    ];
    unset( $row['cellphone'] );
    $row['email'] = strtolower ( $row['email'] );
    $row['sisben'] = $row['sisben'] == 1 ? 'SI' : 'NO';
    $row['regime'] = $row['regime'] == 1 ? 'C' : 'S';
    return $row;
}, $rows);

return generate_insert_table('tb_persons', $rows);