<?php

use App\Models\CasesModel;
use HNova\Rest\req;
use HNova\Rest\res;
use HNova\Rest\router;

# routes cases/:caseId

router::post('/', function(){

    $model = new CasesModel();

    $ok = $model->addComment(req::params()->caseId, req::body());

    if ( $ok ){
        return $ok;
    }

    return res::sendStatus(500);
});