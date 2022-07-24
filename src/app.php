<?php

namespace App;

class app
{
    static function userID():int{
        return $_ENV['app-user']['id'];
    }
    
    static function userName():string{
        return $_ENV['app-user']['name'];
    }

    static function getToken():string {
        return $_ENV['app-token'];
    }
}