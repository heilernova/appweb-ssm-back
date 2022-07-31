<?php

use HNova\Db\db;

$report = [];

// $sql= "SELECT 
// t1.id,
// CONCAT(t1.name, ' ', t1.lastName) as 'name'
// FROM tb_users t1
// INNER JOIN tb_surveys_answers t2 ON t2.user = t1.id
// group by t1.id
// ";

$sql = "SELECT id, lower(CONCAT(name, ' ', lastName)) AS 'name' FROM tb_users";
$pollster = db::pull()->query($sql)->rows();

$answers = db::pull()->query("SELECT id, `date`, user, type FROM tb_surveys_answers")->rows();

$report['pollster'] = $pollster;
$report['answers'] = $answers;

return $report;