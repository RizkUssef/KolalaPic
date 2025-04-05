<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Models\Photo;
use MongoDB\BSON\ObjectID;

class apiShowOneController extends apiController
{
    // protected $photoName ;
    public function showOne()
    {
        $api = new Api;
        if (Request::checkGetExist("id")) {
            $id = Request::get("id");
            $filter = ["_id" => new ObjectID($id)];
            $photoData = $api->one(Photo::class, $filter);
            echo $photoData;
        } else {
            echo json_encode("wrong data");
        }
    }

    public function downloadPhoto(){
        $api = new Api;
        if (Request::checkGetExist("id")) {
            $id = Request::get("id");
            $filter = ["_id" => new ObjectID($id)];
            $photoData = $api->one(Photo::class, $filter);
            $photo = json_decode($photoData);
            $photoName = $photo->file;
            $filePath = "C:/xampp/htdocs/KolalaPic/public/uploads/$photoName"; // Or however you get the filename
            if (file_exists($filePath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream'); // Force download
                header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
                readfile($filePath);
                exit;
            }
        } else {
            echo json_encode("wrong data");
        }
    }
}
