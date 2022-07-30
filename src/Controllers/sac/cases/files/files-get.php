<?php

use HNova\Rest\req;
use HNova\Rest\res;

$case_id = req::params()->caseId;
$name_file = req::params()->name;

// return res::file(__DIR__ . '/cases-post.php');

$dir = $_ENV['api-rest-dir'] . '/../files/cases/' . str_pad($case_id, 5, '0', STR_PAD_LEFT);
// return $dir;
if ( file_exists($dir) ){

    $path = "$dir/$name_file";

    // return $dir;
    if ( file_exists($path) ){
        return res::file($path);
    }

}

return res::text( (file_exists($path) ? "Si" : "No") . $dir . " ** "  .( $path ?? ''))->status(404);