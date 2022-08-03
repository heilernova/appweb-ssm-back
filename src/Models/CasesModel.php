<?php

namespace App\Models;

use App\app;
use HNova\Db\Pull;
use HNova\Rest\api;

class CasesModel{
    
    private string $slq_select = "";
    private Pull $db;
    function __construct()
    {
        $this->slq_select = file_get_contents(__DIR__ . '/Cases/select.sql');
        $this->db = new Pull();
    }

    private function map($row):array {
        $row['date'] = $row['date'] . "z";
        $row['user'] = json_decode( $row['user'] );
        $row['comments'] = json_decode($row['comments']);
        // $row['cellphones'] = json_decode($row['cellphones']);
        $row['client'] = json_decode($row['client']);
        $row['populationGroup'] = json_decode($row['populationGroup']);

        foreach( $row['populationGroup'] as $key => $value ){
            $row['populationGroup']->$key = (bool)$value;
        }

        # Agregamos los files si los tiene
        $row['files'] = [];
        $dir = $_ENV['api-rest-dir'] . "/files/cases/" . str_pad($row['id'], 5, '0', STR_PAD_LEFT);

        if ( file_exists($dir) ){
            $row['files'] = array_map(fn($x) => basename($x), glob("$dir/*") ?? []);
        }

        return $row;
    }

    function getAll():array {
        $rows = $this->db->query("SELECT * FROM vi_cases")->rows();
        return array_map(fn($item) => $this->map($item), $rows);
    }

    function get(int $id):?array{
        // $sql = str_replace('group by t1.id', 'where t1.id = ? group by t1.id ', $this->slq_select);
        $row = $this->db->query("SELECT * FROM vi_cases WHERE id = ?", [ $id ])->rows()[0] ?? null;
        return $row ? $this->map( $row ) : null;
    }

    function create(array $data):int{
        $data['user'] = app::userID();
        $data['status'] = 'A';
        return $this->db->insert($data, 'tb_sac_cases', 'id')->rows()[0]['id'];
    }

    function addComment(int $caseId, string $comment):?array{

        $data = [
            'case' => $caseId,
            'user' => (int)app::userID(),
            'content' => $comment
        ];

        $sql = "INSERT INTO tb_sac_cases_comments(`case`, user, content) VALUES(:case, :user, :content) returning *";
        
        $row = $this->db->query($sql, $data)->rows()[0] ?? null;

        if ( $row ){
            $row['user'] = [
                'id' => $row['user'],
                'name' => app::userName()
            ];

            return $row;
        }
        return null;
    }
}