<?php

use HNova\Db\db;
use HNova\Db\Pull;
use HNova\Rest\req;
use HNova\Rest\router;


router::use('/cases', fn() => require __DIR__.'/cases/.router.php');

router::get('/data', fn() => require __DIR__ . '/get-data.php');

router::put('/comments/:id', function(){
    $id = req::params()->id;
    $content = req::body();
    $db = new Pull();
    $sql = "UPDATE tb_sac_cases_comments SET content = ? where id = ?";
    return $db->query($sql, [$content, $id])->rowCount > 0;
});