<?php

use App\appfiles;
use App\Models\CasesModel;
use HNova\Rest\req;
use HNova\Rest\res;
use HNova\Rest\Response;

$m = new CasesModel();

$body = json_decode( req::body()['json'] );

$id = $m->create((array)$body);

$case = $m->get($id);

if ( $case ){
    $case['files'] = [];
    foreach ( req::files() as $file ){
        appfiles::casesSalve($id, $file->tmpName,  $file->name);
    }
    return $case;
}else{
    return res::sendStatus(500);
}