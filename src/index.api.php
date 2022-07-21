<?php

require __DIR__ . '/../vendor/autoload.php';

use HNova\Rest\api;

api::use('/', fn() => require __DIR__ . '/Controllers/.router.php');
api::run();