<?php

namespace Rizk\Kolala\Classes;

use Rizk\Kolala\Models\Photo;

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

    public function all($modle,$filter=[]) {
        $obj = new $modle;
        $all_data = $obj->selectMany($filter);
        if($all_data != null){
            return json_encode($all_data);
        }else{
            return json_encode("no data found");
        }
    }
    public function one($modle,$filter=[]){
        $obj = new $modle;
        $all_data = $obj->selectOne($filter);
        if($all_data != null){
            return json_encode($all_data);
        }else{
            return json_encode("no data found");
        }
    }

}