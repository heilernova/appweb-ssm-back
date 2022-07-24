<?php

use HNova\Db\db;

$db = db::pull();

$map = function($type, $rows):array{

    return array_map(function($row) use ($type){

        $temp =  array_splice($row, 0, 4);
        $data['date'] = $temp['date'];
        $data['user'] = $temp['user'];
        $data['type'] = $type;
        $data['dni'] = $temp['dni'];
        // unset($temp['id']);

        // $data = array_splice($temp, 0, 3);
        // $data['type'] = $type;
        // $data = [...$data, ...$temp];


        $data['answers'] = [];
    
        foreach ($row as $key => $value) {
            $data['answers'][str_replace('ask', 'res', $key)] = $value;
        }
    
        return $data;
    
    }, $rows);

};


# EPS
$rows = array_map(function($row){
    $row['ask01'] = trim( strtoupper($row['ask01']) );
    if ( $row['ask01'] == "1" )  $row['ask01'] = "NUEVA EPS";
    return $row;
}, $db->query("SELECT * FROM tb_surveys_eps")->rows());
$surveys = $map(1, $rows);

#IPS
$rows = array_map(function($row){
    $row['ask01'] = trim( strtoupper($row['ask01']) );
    return $row;
}, $db->query("SELECT * FROM tb_surveys_ips")->rows());
$surveys = [ ...$surveys, ... $map(2, $rows) ];

# Hospital
$rows = array_map(function($row){
    return $row;
}, $db->query("SELECT * FROM tb_surveys_ips_hospitalization")->rows());
$surveys = [ ...$surveys, ... $map(3, $rows) ];

# Laboratorio
$rows = array_map(function($row){
    $row['ask01'] = trim( strtoupper( $row['ask01'] ) );
    return $row;
}, $db->query("SELECT * FROM tb_surveys_ips_laboratorys")->rows());
$surveys = [ ...$surveys, ... $map(4, $rows) ];

# Odontología
$rows = array_map(function($row){
    $row['ask01'] = trim( strtoupper( $row['ask01'] ) );
    return $row;
}, $db->query("SELECT * FROM tb_surveys_ips_odontology")->rows());
$surveys = [ ...$surveys, ... $map(5, $rows) ];

# Farmacia
$rows = array_map(function($row){
    $row['ask01'] = trim( strtoupper( $row['ask01'] ) );
    return $row;
}, $db->query("SELECT * FROM tb_surveys_ips_pharmacy")->rows());
$surveys = [ ...$surveys, ... $map(6, $rows) ];

# Ordenamos por fechas el array
// asort()
uasort($surveys, function($a, $b){
    return (strcmp($a['date'], $b['date']));
});


# SQL

return generate_insert_table('tb_surveys_answers', $surveys);

// return $sql . ";";