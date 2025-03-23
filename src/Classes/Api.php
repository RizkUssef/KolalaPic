<?php

namespace Rizk\Kolala\Classes;

use Rizk\Kolala\Models\Photo;
use MongoDB\Client;

class Api{
    public function __construct()
    {
        // header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Content-Type: application/json");
        header("Access-Control-Allow-Credentials:true");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE ");
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit(); 
        }
    }

    public function homeAll($modle,$filter=[]){
        $obj = new $modle;
        $all_data = $obj->selectMany($filter); 
    }

    public function all($modle,$filter=[]) {
        $obj = new $modle;
        $all_data = $obj->selectMany($filter);
        if($all_data != null){
            http_response_code(200);
            return json_encode($all_data);
        }else{
            http_response_code(404);
            return json_encode(["error"=>"no data found"]);
        }
    }
    
    public function one($modle,$filter=[]){
        $obj = new $modle;
        $all_data = $obj->selectOne($filter);
        if($all_data != null){
            http_response_code(200);
            return json_encode($all_data);
        }else{
            http_response_code(404);
            return json_encode(["error"=>"no data found"]);
        }
    }

    public function insertUser($modle, $document){
        $obj = new $modle;
        $insertResult = $obj->insert($document);
        if($insertResult){
            http_response_code(200);
            return  json_encode(["success"=>'resgistered succussfully']);
        }else{
            http_response_code(404);
            return json_encode(["error"=>"error happened try again later !"]);
        }
    }



}