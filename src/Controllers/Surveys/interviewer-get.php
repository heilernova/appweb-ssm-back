<?php

use HNova\Db\db;

$pull = db::pull();

return $pull->query("SELECT id, LOWER( CONCAT(`name`, ' ', `lastName`) ) as 'name' FROM tb_users WHERE `disable` = 0")->rows();