<?php

namespace Rizk\Kolala\Classes;

class Api{
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        header("Access-Control-Allow-Credentials:true");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE ");
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit(); 
        }
    }
}