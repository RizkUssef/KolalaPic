<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Models\Photo;

class apiShowAllController extends apiController{
    public function showAll()
    {
        $api = new Api;
        if (Request::checkGetExist("category")) {
            $cate = Request::get("category");
            echo ($api->all(Photo::class, ["category" => $cate]));
        } else {
            echo ($api->all(Photo::class));
        }
    }
}