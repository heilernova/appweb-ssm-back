<?php

use App\Models\PersonsModel;
use HNova\Rest\req;
use HNova\Rest\res;

$model = new PersonsModel();

$res = $model->get(req::params()->id);

if ( $res ) return $res;

return res::text('')->status(404);