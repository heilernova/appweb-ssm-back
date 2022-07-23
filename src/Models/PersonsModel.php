<?php
namespace App\Models;

use HNova\Db\Pull;

class PersonsModel{
    public function __construct(
        private Pull $pull = new Pull()
    ){
        
    }

    public function dniValid(string $dni ): bool
    {
        return $this->pull->query("SELECT * FROM tb_persons WHERE dni = ?", [ $dni ])->rowCount > 0;
    }

    private function map($row):array{
        $row['cellphones'] = json_decode($row['cellphones']);
        return $row;
    }

    public function create(array|object $data)
    {
        return $this->pull->insert($data, 'tb_persons', '*')->rows()[0];
    }
}