<?php

namespace Rizk\Kolala\Classes;

class Response{
    public static function msg($msg,$code){
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($msg);
    }
}