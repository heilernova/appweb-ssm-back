<?php

namespace App;

class app
{
    static function user():object{
        return $_ENV['app-user'];
    }

    static function getToken():string {
        return $_ENV['app-token'];
    }
}