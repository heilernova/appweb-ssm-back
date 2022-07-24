<?php

function generate_insert_table(string $table, $rows):string{

    $text = "-- Tabla: $table\n\n";

    $fields = "";
    foreach ( $rows[0] as $key => $value ){
        $fields .= ", `$key`";
    }
    $fields = ltrim($fields, ', ');
    $text .= "INSERT INTO $table($fields)\nVALUES\n";

    foreach ( $rows as $row) {
        $text .= row_to_sql($row) . ",\n";
    }

    return rtrim($text, ",\n") . ";";
}

function row_to_sql(array $row):string{

    $values = "";
    foreach ( $row as $key => $value ){

        if ( is_object($value) || is_array($value) ){
            $value = json_encode($value);
            $values .= ", '$value'";
        }else if ( is_null($value) ){
            $values .= ", NULL";
        }else{
            $values .= ", '$value'";
        }
    }

    return "(" . ltrim($values, ', ') . ")";
}