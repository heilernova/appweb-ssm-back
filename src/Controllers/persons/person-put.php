<?php



# Inicialos el Objeto para interactuar con la base de datos.
use App\Models\PersonsModel;
use HNova\Rest\req;
use HNova\Rest\res;

$model = new PersonsModel();
$body = req::body();
$id = req::params()->id;

unset($body->dni);

if ( !$model->dniExists( $id ) ) return res::sendStatus( 404 );

return $model->update($id, (array)$body);