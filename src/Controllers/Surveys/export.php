<?php

use HNova\Db\db;
use HNova\Rest\req;
use HNova\Rest\res;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

use function PHPSTORM_META\map;

$filter = json_decode( $_GET['filter'] );

$date_start = $filter->dateStart;
$date_end = $filter->dateEnd . " 23:59:59";
$users = "";
foreach ( $filter->users as $id ){
    $users .= " OR `user`=?";
}
$users = ltrim($users, ' OR');

// $fields = "id, date, interviewer,"
$slq = "SELECT * FROM vi_surveys_excel WHERE (`date` BETWEEN ? AND ?) AND ( $users ) order by id";
$rows = db::pull()->query($slq, [$date_start, $date_end, ...$filter->users])->rows();

/*******************************
 * Mapeamos las respues
 */

$rows = array_map(function($row){

    $row['answers'] = json_decode( $row['answers'] );

    switch ($row['type']) {
        case 1:
            # EPS

            # 02
            $row['answers'][1] = match( $row['answers'][1] ){
                1 => "Vigilante",
                2 => "Promotor",
                3 => "Recepcionista",
                default => $row['answers'][1]
            };
            break;
        
        case 2:
            # IPS

            # 04
            $row['answers'][3] = match( $row['answers'][3] ){
                1 => '1 día después',
                2 => '2 a 3 días después',
                3 => '4 a 5 días después',
                4 => '8 días después',
                5 => 'Mas de 10 días',
                default => null
            };

            # 05
            $row['answers'][4] = match ( $row['answers'][4] ){
                1 => 'Amabilidad',
                2 => 'Normalidad',
                3 => 'Indisposición',
                4 => 'Apatía',
                default => null
            };

            # 06
            $row['answers'][5] = match ( $row['answers'][5] ){
                1 => 'Inmediata',
                2 => '10 minutos',
                3 => '15 minutos',
                4 => '20 minutos',
                5 => ' mas de 30 minutos',
                default => null
            };

            # 07
            $row['answers'][6] = match( $row['answers'][6] ){
                1 => 'Medicina general',
                2 => 'Farmacia',
                3 => 'Laboratorío clínico',
                4 => 'Odontología',
                5 => 'PyP',
                default => null
            };
            break;

        case 3:

            # HOSPITAL
            $row['answers'][0] = match( $row['answers'][0] ){
                1 => 'Servicio de urgencias',
                2 => 'Cirugía programada',
                default => null
            };

            # 02 
            $row['answers'][1] = match( $row['answers'][1] ){
                1 => 'Inmediatamente',
                2 => 'Entre 20 a 40 minutos',
                3 => 'Mas de 40 minutos',
                default => null
            };
        
            # 03
            $row['answers'][2] = match( $row['answers'][2] ){
                1 => 'Vigilante',
                2 => 'Auxilizar',
                3 => 'Recepcionista',
                4 => 'Médico',
                5 => 'Enfermero',
                6 => 'Nadie me recibio',
                default => null
            };

            # 05
            $row['answers'][4] = match( $row['answers'][4] ){
                1 => 'Documento de identidad',
                2 => 'Autorización',
                default => $row['answers'][4]
            };
            break;

        case 4:
            # Farmacia

            # 04
            $row['answers'][3] = match( $row['answers'][3] ){
                1 => 'Inmediato',
                2 => 'A las 24 horas',
                3 => 'Mas de 48 horas',
                default => $row['answers'][3]
            };
            # 07
            // $row['answers'][6] = match( $row['answers'][6] ){
            //     1 => 'Si',
            //     2 => 'No',
            //     3 => 'No sabe',
            //     default => null
            // };

            # 9
            // $row['answers'][8] = match( $row['answers'][8] ){
            //     1 => '1 - 30 minutos',
            //     2 => '30 - 60 minutos',
            //     3 => 'Mas de 1 hora',
            //     4 => 'Mas de 2 horas',
            //     default => null
            // };
            break;

        case 5:
            # Laboratorio

            # 8
            $row['answers'][7] = match( $row['answers'][7] ){
                1 => 'El mismo día',
                2 => 'A los 2 días',
                3 => 'A los 5 días',
                4 => 'A los 8 días',
                default => null
            };
            break;

        case 6:
            # Medician general
            $row['answers'][1] = match( $row['answers'][1] ){
                1 => 'El mismo día',
                2 => '1 días después',
                3 => '5 días después',
                4 => '8 días después',
                default => null
            };
            break;
        case 7:
            $row['answers'][1] = match( $row['answers'][1] ){
                1 => 'El mismo día',
                2 => '1 días después',
                3 => '5 días después',
                4 => '8 días después',
                default => null
            };
            break;
        
        default:
            # code...
            break;
    }

    return $row;
}, $rows);



// Cargamos el excel para cargar generar el reporte
$reader = IOFactory::createReader("Xlsx");
$spread_sheet = $reader->load(__DIR__.'/Surveys.xlsx');
$row_index[1] = 3;
$row_index[2] = 3;
$row_index[3] = 3;
$row_index[4] = 3;
$row_index[5] = 3;
$row_index[6] = 3;
$row_index[7] = 3;


foreach ( $rows as $row ){
    $type = $row['type'];

    unset($row['user']);
    unset($row['type']);

    $cells = json_decode($row['cellphones']);
    $row['cellphones'] = "";
    foreach ($cells as $cell){
        $num = $cell->num;
        $row['cellphones'] .= " - " . "(" . substr($num, 0, 3) . ") " . substr($num, 3, 3) . "-".substr($num, 6); 
    }

    $row['cellphones'] = ltrim($row['cellphones'] , ' - ');

    $colum_index = 1;
    $sheet = $spread_sheet->getSheet($type - 1);
    // $sheet->setCellValueByColumnAndRow(2, 3, 'Heiler nova');
    foreach ( $row as $key => $value ){

        if ( $key == "date" ){
            $value = Date::PHPToExcel($value);
            $sheet->setCellValueByColumnAndRow($colum_index,  $row_index[$type], $value);
            $colum_index++;
        }else if ( $key == "birthDate" ){
            $value = Date::PHPToExcel($value);
            $sheet->setCellValueByColumnAndRow($colum_index,  $row_index[$type], $value);
            $colum_index++;
        }else if ( $key == "answers" ){

            foreach ( $value  as $val ){
                if ( is_object($val) ){

                    $sheet->setCellValueByColumnAndRow($colum_index,  $row_index[$type], $val->response );
                    $colum_index++;

                    foreach ($val->subResponses as $sub){
                        $sheet->setCellValueByColumnAndRow($colum_index,  $row_index[$type], $sub );
                        $colum_index++;
                    }
                }else{
                    $sheet->setCellValueByColumnAndRow($colum_index,  $row_index[$type], $val);
                    $colum_index++;
                }
            }

        }else{
            $sheet->setCellValueByColumnAndRow($colum_index,  $row_index[$type], $value);
            $colum_index++;
        }
    }
    $row_index[$type]++;
}

$writer = IOFactory::createWriter($spread_sheet, 'Xlsx');
$writer->save(__DIR__ . '/temp.xlsx');

return res::file(__DIR__ . '/temp.xlsx', true);
