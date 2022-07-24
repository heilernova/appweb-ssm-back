<?php
namespace App\Models;

use HNova\Db\Pull;

class PersonsModel{
    public function __construct(
        private Pull $pull = new Pull()
    ){
        
    }

    public function dniExists(string $dni ): bool
    {
        return $this->pull->query("SELECT * FROM tb_persons WHERE dni = ?", [ $dni ])->rowCount > 0;
    }

    private function map($row):array{
        $row['name'] = strtolower($row['name']);
        $row['lastName'] = strtolower($row['lastName']);
        $row['cellphones'] = json_decode($row['cellphones']);
        return $row;
    }

    public function get(string $dni):?array{
        $row = $this->pull->query("SELECT * FROM tb_persons WHERE dni = ?", [ $dni ])->rows()[0] ?? null;
        return $row ? $this->map( $row ) : null;
    }

    public function create(array|object $data):?array
    {
        $row = $this->pull->insert($data, 'tb_persons', '*')->rows()[0] ?? null;
        return $row ? $this->map( $row ) : null;
    }

    public function update(string $dni, $data):bool{
        return $this->pull->update($data, [ 'dni=:dni',[ 'dni' => $dni] ], 'tb_persons')->rowCount > 0;
    }
}