<?php

use HNova\Db\Pull;

$pull = new Pull();

return $pull->query("SELECT * FROM tb_dni_types")->rows();