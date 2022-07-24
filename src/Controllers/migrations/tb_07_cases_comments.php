<?php

use HNova\Db\db;
use HNova\Db\Pull;

$rows = db::pull()->query("SELECT * FROM tb_sac_cases_comments")->rows();

$rows = array_map(function( $row ){

    // unset( $row['token'] );

    // $row['email'] = strtolower( $row['email'] );

    return $row;
}, $rows);

return generate_insert_table('tb_sac_cases_comments', $rows);