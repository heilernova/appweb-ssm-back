<?php

require __DIR__ . '/../vendor/autoload.php';

use HNova\Rest\api;

api::use('/', fn() => require __DIR__ . '/index.routes.php');
api::run();