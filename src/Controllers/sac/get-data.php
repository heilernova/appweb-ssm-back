<?php

use HNova\Db\Pull;

$pull = new Pull();


$eps_list = $pull->query("SELECT id, lower(name) as 'name', disable FROM tb_eps")->rows();
$attention_list = $pull->query("SELECT * FROM tb_sac_cases_required_attentions")->rows();

return [
    'eps' => $eps_list,
    'requiredAttentions' => $attention_list
];