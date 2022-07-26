<?php

use HNova\Db\db;

use function PHPSTORM_META\map;

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
            $data['answers'][] = $value;
        }
    
        return $data;
    
    }, $rows);

};

function map_answer_okey_regular_bad( $value ){
    return match( $value ){
        1 => "Malo",
        2 => "Regular",
        3 => "Bueno",
        default => null
    };
};
function map_answer_yes_no( $value ){
    return match( $value ){
        1 => "Si",
        2 => "No",
        default => null
    };
};

# -----------------------------------------------------------------------
# -----------------------------------------------------------------------
# EPS
$rows = array_map(function($row){
    $row['ask01'] = trim( strtoupper($row['ask01']) );
    if ( $row['ask01'] == "1" )  $row['ask01'] = "NUEVA EPS";

    # Mapeamos las respustas
    $requests = require __DIR__ . './../Surveys/Questions/question_01.php';

    $row['ask02'] = match ( $row['ask02'] ) {
        "1" => "Vigilante",
        "2" => "Promotor",
        "3" => "Recepcionista",
        default => $row['ask02']
    };

    $row['ask03'] = map_answer_yes_no( $row['ask03'] );

    return $row;
}, $db->query("SELECT * FROM tb_surveys_eps")->rows());
$surveys = $map(1, $rows);

/************************************************************************
 * IPS
 */
$rows = array_map(function($row){
    $row['ask01'] = trim( strtoupper($row['ask01']) );

    $row['ask02'] = map_answer_okey_regular_bad( $row['ask02']);
    $row['ask03'] = map_answer_yes_no( $row['ask03'] );
    $row['ask04'] = match( $row['ask04'] ){
        1 => "1 día después",
        2 => "2 a 3 días después",
        3 => "4 a 5 días después",
        4 => "8 días después",
        5 => "Mas de 10 días después",
        default => null
    };
    $row['ask05'] = match( $row['ask05'] ){
        1 => 'Amabilidad',
        2 => 'Normaliadad',
        3 => 'Indisposición',
        4 => 'Apatía',
        default => null
    };
    $row['ask06'] = match( $row['ask06'] ){
        1 => 'Inmediata',
        2 => '10 minutos',
        3 => '15 minutos',
        4 => '20 minutos',
        5 => 'Mas de 30 minutos',
        default => null
    };
    $row['ask07'] = match( $row['ask07'] ){
        1 => 'Medicina general',
        2 => 'Farmacia',
        3 => 'Laboratorío clínico',
        4 => 'Odontología',
        5 => 'PyP',
        default => null
    };
    $row['ask08'] = map_answer_okey_regular_bad( $row['ask08'] );
    $row['ask09'] = map_answer_yes_no( $row['ask09'] );
    $row['ask10'] = map_answer_okey_regular_bad( $row['ask10'] );

    // $row['ask10'] = 

    return $row;
}, $db->query("SELECT * FROM tb_surveys_ips")->rows());
$surveys = [ ...$surveys, ... $map(2, $rows) ];

/*****************************************************************************
 * HOSPITAL
 */
$rows = array_map(function($row){

    $row['ask01'] = match( $row['ask01'] ){
        1 => 'Servicio de urgencias',
        2 => 'Cirugpía programada',
        default => null
    };
    $row['ask02'] = match( $row['ask02'] ){
        1 => 'Inmediatamente',
        2 => 'Entre 20 y 40 minutos',
        3 => 'Mas de 40 minutos',
        default => null
    };
    $row['ask03'] = match( $row['ask03'] ){
        1 => 'Vigilante',
        2 => 'Auxiliar',
        3 => 'Recepcionista',
        4 => 'Médito',
        5 => 'Enfermero',
        6 => 'Nadie me recibio',
        default => null
    };
    $row['ask04'] = map_answer_yes_no( $row['ask04'] );
    $row['ask05'] = match( $row['ask05'] ){
        1 => 'Documento de identificación',
        2 => 'Autorización',
        default => null
    };
    $row['ask06'] = map_answer_okey_regular_bad( $row['ask06'] );
    $row['ask07'] = map_answer_okey_regular_bad( $row['ask07'] );
    $row['ask08'] = map_answer_yes_no( $row['ask08'] );
    $row['ask09'] = map_answer_yes_no( $row['ask09'] );
    $row['ask10'] = map_answer_okey_regular_bad( $row['ask10'] );
    return $row;
}, $db->query("SELECT * FROM tb_surveys_ips_hospitalization")->rows());
$surveys = [ ...$surveys, ... $map(3, $rows) ];

/**********************************************************************
 * Laboratorio
 */
$rows = array_map(function($row){
    
    $row['ask01'] = trim( strtoupper( $row['ask01'] ) );
    $row['ask02'] = map_answer_okey_regular_bad( $row['ask02'] );
    $row['ask03'] = map_answer_okey_regular_bad( $row['ask03'] );
    $row['ask04'] = map_answer_okey_regular_bad( $row['ask04'] );
    $row['ask05'] = match( $row['ask05'] ){
        1 => 'Inmediatamente',
        2 => '1 hora',
        3 => '2 horas',
        4 => 'Mas de 3 horas',
        default => null
    };
    $row['ask06'] = map_answer_okey_regular_bad( $row['ask06'] );
    $row['ask07'] = map_answer_okey_regular_bad( $row['ask07'] );
    $row['ask08'] = match( $row['ask08'] ){
        1 => 'El mismo día',
        2 => 'A los 2 días',
        3 => 'A los 5 días',
        4 => 'A los 8 días',
        default => null
    };
    $row['ask09'] = map_answer_yes_no( $row['ask09'] );
    $row['ask10'] = map_answer_okey_regular_bad( $row['ask10'] );

    return $row;
}, $db->query("SELECT * FROM tb_surveys_ips_laboratorys")->rows());
$surveys = [ ...$surveys, ... $map(4, $rows) ];

/***********************************************************************
 * Odontología
 */
$rows = array_map(function($row){
    $row['ask01'] = trim( strtoupper( $row['ask01'] ) );
    $row['ask02'] = match( $row['ask02']){
        1 => 'El mismo día',
        2 => 'Un día después',
        3 => '5 días después',
        4 => '8 días después',
        default => null
    };
    $row['ask03'] = map_answer_okey_regular_bad( $row['ask03']);
    $row['ask04'] = map_answer_yes_no( $row['ask04']);
    $row['ask05'] = map_answer_yes_no( $row['ask05']);
    $row['ask06'] = map_answer_okey_regular_bad( $row['ask06']);
    $row['ask07'] = map_answer_okey_regular_bad( $row['ask07']);
    $row['ask08'] = map_answer_okey_regular_bad( $row['ask08']);
    $row['ask09'] = map_answer_okey_regular_bad( $row['ask09']);
    $row['ask10'] = map_answer_okey_regular_bad( $row['ask10']);
    
    return $row;
}, $db->query("SELECT * FROM tb_surveys_ips_odontology")->rows());
$surveys = [ ...$surveys, ... $map(5, $rows) ];

# Farmacia
$rows = array_map(function($row){
    $row['ask01'] = trim( strtoupper( $row['ask01'] ) );
    $row['ask02'] = map_answer_okey_regular_bad( $row['ask02']);
    $row['ask03'] = map_answer_okey_regular_bad( $row['ask03']);
    $row['ask04'] = match( $row['ask04'] ){
        1 => 'Inmediato',
        2 => 'A las 24 horas',
        3 => 'Mas de 48 horas',
        default => null
    };
    $row['ask05'] = map_answer_yes_no( $row['ask05']);
    $row['ask06'] = map_answer_yes_no( $row['ask06']);
    $row['ask07'] = match( $row['ask07'] ){
        1 => 'Si',
        2 => 'No',
        3 => 'No sabe',
        default => null
    };
    $row['ask08'] = map_answer_okey_regular_bad( $row['ask08']);
    $row['ask09'] = match( $row['ask09'] ){
        1 => '1 a 30 minutos',
        2 => '30 a 60 minutos',
        3 => 'Mas de 1 hora',
        4 => 'Mas de 2 horas',
        default => null
    };
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