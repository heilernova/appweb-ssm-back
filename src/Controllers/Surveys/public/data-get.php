<?php

use HNova\Db\db;

$pull = db::pull();

$interviwer = $pull->query("SELECT id, LOWER( CONCAT(`name`, ' ', `lastName`) ) as 'name' FROM tb_users WHERE `disable` = 0")->rows();

$surveys = $pull->query("SELECT * FROM tb_surveys_questions")->rows();

$surveys =  array_map(function($item){
    $id = $item['id'];
    $dir = str_replace('00.json', str_pad("$id", 2, '0', STR_PAD_LEFT) . ".json", __DIR__ . './../questions/question_00.json');

    $item['questions'] = file_exists($dir) ? json_decode( file_get_contents( $dir ) ) : [];
    return $item;
}, $surveys);

return [
    'interviwers' => $interviwer,
    'surveys' => $surveys
];