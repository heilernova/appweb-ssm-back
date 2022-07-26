<?php
namespace App;

use HNova\Rest\req;

class appfiles
{

    private static function mapName($name):string{

        // $name = str_replace(' ', ' ', $name);
        // $name = str_replace(' - ', '__', $name);
        // $name = str_replace(' ', '_', $name);
        $name = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $name
        );

        //Reemplazamos la E y e
        $name = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $name );

        //Reemplazamos la I y i
        $name = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $name );

        //Reemplazamos la O y o
        $name = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $name );

        //Reemplazamos la U y u
        $name = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $name );

        //Reemplazamos la N, n, C y c
        $name = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç'),
        array('N', 'n', 'C', 'c'),
        $name
        );

        return $name;
    }


    static function casesSalve(int $case, string $path, $name):string|false {
        if ( !file_exists( __DIR__ . '/../files' ) ) mkdir(__DIR__ . '/../files');
        if ( !file_exists( __DIR__ . '/../files/cases' ) ) mkdir(__DIR__ . '/../files/cases');

        $dir = __DIR__ . '/../files/cases/' . str_pad($case, 5, '0', STR_PAD_LEFT);

        if ( !file_exists($dir) ) mkdir($dir);

        if ( req::httpMethod() == 'POST' ){
            // $name = self::mapName($name);
            $name = str_replace('.PDF', '.pdf', $name);
            return move_uploaded_file($path, $dir . "/" . $name ) ? $name : false;
        }
        return false;
    }

    static function deleteFileCase(int $case, $name):bool{
        $dir = __DIR__ . '/../files/cases/' . str_pad($case, 5, '0', STR_PAD_LEFT) . "/$name";

        return unlink($dir);
    }

    static function renameFileCase(int $case, $name, $new_name){
        $dir = __DIR__ . '/../files/cases/' . str_pad($case, 5, '0', STR_PAD_LEFT) . "/$name";
        $dir_2 = __DIR__ . '/../files/cases/' . str_pad($case, 5, '0', STR_PAD_LEFT) . "/$new_name";

        // pathinfo($name, PATHINFO_EXTENSION);
        return rename($dir, $dir_2);
    }

}