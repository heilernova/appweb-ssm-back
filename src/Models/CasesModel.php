<?php

namespace App\Models;

use App\app;
use HNova\Db\Pull;

class CasesModel{
    
    private string $slq_select = "";
    private Pull $db;
    function __construct()
    {
        $this->slq_select = file_get_contents(__DIR__ . '/Cases/select.sql');
        $this->db = new Pull();
    }

    private function map($row):array {
        $row['user'] = json_decode( $row['user'] );
        $row['comments'] = json_decode($row['comments']);
        $row['cellphones'] = json_decode($row['cellphones']);
        return $row;
    }

    function getAll():array {
        $rows = $this->db->query($this->slq_select)->rows();
        return array_map(fn($item) => $this->map($item), $rows);
    }

    function get(int $id):?array{
        $sql = str_replace('group by t1.id', 'where t1.id = ? group by t1.id ', $this->slq_select);
        $row = $this->db->query($sql, [ $id ])->rows()[0] ?? null;
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