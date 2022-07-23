<?php

use App\Models\PersonsModel;
use HNova\Db\Pull;
use HNova\Rest\req;
use HNova\Rest\res;

# Inicialos el Objeto para interactuar con la base de datos.
$model = new PersonsModel();

# Objeto con los datos del usuario.
$body = req::body();

# Verificamos el número de documento no este en uso.
$dni_exists = $model->dniExists($body->dni);

if ( $dni_exists ) {
    return [
        'message' => "El número de documento ya esta en uso"
    ];
}

# Registramos los datos de la persona
$person_data = $model->create($body);

if ( $person_data ){
    return [ 'person' => $person_data ];
}

return res::text("No se pudo realizar el registro")->status(500);