<?php

use HNova\Db\db;

$pull = db::pull();


$eps = $pull->query("SELECT * FROM tb_eps")->rows();
$ips = $pull->query("SELECT * FROM tb_ips")->rows();

$interviwer = $pull->query("SELECT id, LOWER( CONCAT(`name`, ' ', `lastName`) ) as 'name' FROM tb_users WHERE `disable` = 0")->rows();

$surveys = $pull->query("SELECT * FROM tb_surveys_questions")->rows();

$surveys =  array_map(function($item){
    $id = $item['id'];
    $dir = str_replace('00.php', str_pad("$id", 2, '0', STR_PAD_LEFT) . ".php", __DIR__ . './../questions/question_00.php');

    $item['questions'] = file_exists($dir) ? require $dir : [];
    return $item;
}, $surveys);

return [
    'interviwers' => $interviwer,
    'eps' => $eps,
    'ips' => $ips,
    'surveys' => $surveys
];