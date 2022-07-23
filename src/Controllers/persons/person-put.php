<?php



# Inicialos el Objeto para interactuar con la base de datos.
use App\Models\PersonsModel;
use HNova\Rest\req;

$model = new PersonsModel();
$body = req::body();

unset($body->dni);

return $model->update(req::params()->id, (array)$body);