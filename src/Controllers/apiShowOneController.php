<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Models\Photo;
use MongoDB\BSON\ObjectID;

class apiShowOneController extends apiController{
    public function showOne()
    {
        $api = new Api;
        if (Request::checkGetExist("id")) {
            $id = Request::get("id");
            $filter = ["_id" => new ObjectID($id)];
            echo $api->one(Photo::class, $filter);
        } else {
            echo json_encode("wrong data");
        }
    }
}