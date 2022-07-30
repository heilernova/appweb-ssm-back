<?php

use App\appfiles;
use HNova\Rest\req;

$case_id = req::params()->caseId;

foreach ( req::files() as $file ){
    $na = appfiles::casesSalve($case_id, $file->tmpName,  $file->name);

    if ( $na ){
        return $na;
    }
}