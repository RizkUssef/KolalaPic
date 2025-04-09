<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Classes\Session;
use Rizk\Kolala\Models\Photo;
use Rizk\Kolala\Models\User;
use MongoDB\BSON\ObjectID;


class apiProfileController
{
    public function __construct()
    {
        session_start();
    }
    public static function showPhotoProfile($interaction)
    {
        if (Request::checkGetExist("user_token")) {
            $api = new Api();
            $user_token = Request::get("user_token");
            if (Session::getSession("user_token") == $user_token) {
                $user = new User();
                $photo = new Photo();
                $filter = ["user_token" => $user_token];
                $userData = $user->selectOne($filter);
                $images = [];
                foreach ($userData->$interaction as $Photos) {
                    $filterPhotos = ["_id" => new ObjectID($Photos)];
                    $images[] = $photo->selectOne($filterPhotos);
                }
                http_response_code(200);
                echo json_encode($images);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "unAuth User"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["error" => "unKnown User"]);
        }
    }
    public function showAllLoved()
    {
        apiProfileController::showPhotoProfile("loved");
    }
    public function showAllSaved(){
        apiProfileController::showPhotoProfile("saved");
    }
}
