<?php

use HNova\Db\db;
use HNova\Rest\req;

$db = db::pull();
$body = req::body();

$db->insert($body, 'tb_surveys_answers');

return true;