<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Models\Photo;
use Rizk\Kolala\Models\User;
use MongoDB\BSON\ObjectID;

class apiController{
    public function showAll(){
        $api = new Api;
        if (Request::checkGetExist("category")) {
            $cate = Request::get("category");
            echo $api->all(Photo::class,["category"=>$cate]);
        }else{
            echo $api->all(Photo::class);
        }
    }
    public function showOne(){
        $api = new Api;
        if(Request::checkGetExist("id")){
            $id = Request::get("id");
            $filter = ["_id" => new ObjectID($id)];
            echo $api->one(Photo::class,$filter);
        }else{
            echo json_encode("wrong data");
        }
    }


}