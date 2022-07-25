<?php

use App\Models\CasesModel;
use HNova\Rest\req;
use HNova\Rest\res;
use HNova\Rest\Response;

$m = new CasesModel();

$body = req::body();

// return res::text(json_encode($body, 128))->status(500);

$id = $m->create((array)$body);

$case = $m->get($id);

if ( $case ){
    return $case;
}else{
    return res::sendStatus(500);
}