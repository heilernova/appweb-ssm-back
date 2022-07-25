<?php

use HNova\Db\db;

$rows = db::pull()->query("SELECT * FROM tb_surveys_answers")->rows();

return $rows;