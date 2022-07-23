<?php

use App\Models\PersonsModel;
use HNova\Db\Pull;
use HNova\Rest\req;

# Inicialos el Objeto para interactuar con la base de datos.
$model = new PersonsModel();

# Objeto con los datos del usuario.
$body = req::body();

# Verificamos el número de documento no este en uso.
$is_invalid = !$model->dniValid($body->dni);

if ( $is_invalid ) {
    return [
        'message' => "El número de documento ya esta en uso"
    ];
}

# Registramos los datos de la persona
$model->create($body);