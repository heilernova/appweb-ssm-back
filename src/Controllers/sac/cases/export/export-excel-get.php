<?php

use HNova\Db\db;
use HNova\Rest\req;
use HNova\Rest\res;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$date_start = req::params()->dateStart;
$date_end = req::params()->dateEnd . " 23:59:59";

$list_1 = db::pull()->query("SELECT * FROM vi_cases_excel WHERE `date` BETWEEN  ? AND ?", [ $date_start, $date_end])->rows();
$list_2 = db::pull()->query("SELECT DISTINCT t1.* FROM vi_cases_excel t1 INNER JOIN tb_sac_cases_comments t2 ON t1.id = t2.case AND t2.date > :f WHERE t1.`date` < :f", [ 'f' => $date_start ])->rows();

$list = array_map(function($row){

    $cells = json_decode($row['cellphones']);

    $row['comments'] = json_decode( $row['comments'] );

    $row['cellphones'] = "";
    foreach ($cells as $cell){
        $num = $cell->num;
        $row['cellphones'] .= " - " . "(" . substr($num, 0, 3) . ") " . substr($num, 3, 3) . "-".substr($num, 6); 
    }

    $row['cellphones'] = ltrim($row['cellphones'] , ' - ');
    return $row;

}, [...$list_1, ...$list_2]);


uasort($list, function($a, $b){
    return (strcmp($a['id'], $b['id']));
});


// Creamos el archivo de excel
$spread_sheet = new Spreadsheet();
// $reader = IOFactory::createReader("Xlsx");
// $spread_sheet = $reader->load(__DIR__ . '/tempo.xlsx');
// $sheet = $spread_sheet->getSheetByName('Worksheet');
$sheet = $spread_sheet->getActiveSheet();

$row_index = 2;
foreach ($list as $row){
    
    $column = 1;

    foreach ( $row as $key => $value){
        if ( $key == 'date' ){
            $value = date::PHPToExcel($value);
        }else if ( $key == 'birthDate' ){
            $value = date::PHPToExcel($value);
        }else if ( $key == 'comments' ){

            $temp = "";
            foreach ( $value as $val ){
                $temp .= "[ " . $val->date . " ]\n";
                $temp .= $val->content . "\n\n";
            }
            $value = $temp;

        }
        $sheet->setCellValueByColumnAndRow($column, $row_index, $value);
        $column++;
    }

    $row_index++;
}

$write = new Xlsx($spread_sheet);
$write->save(__DIR__ . '/temp.xlsx');

return res::file( __DIR__ . '/temp.xlsx' );