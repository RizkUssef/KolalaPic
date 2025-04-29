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
        // Api::handleCros();
        $api = new Api();
        $headers = getallheaders();
        if (isset($headers["tkn"])) {
            $tkn = $headers["tkn"];
            if (Session::getSession("user_token") == $tkn) {
                $user = new User();
                $photo = new Photo();
                $filter = ["user_token" => $tkn];
                $userData = $user->selectOne($filter);
                $images = [];
                if(isset($userData->$interaction)){
                    foreach ($userData->$interaction as $Photos) {
                        $filterPhotos = ["_id" => new ObjectID($Photos)];
                        $images[] = $photo->selectOne($filterPhotos);
                    }
                    http_response_code(200);
                    echo json_encode($images);
                }else{
                    http_response_code(404);
                    echo json_encode(["error" => "you don't $interaction yet"]);                    
                }
            } else {
                http_response_code(404);
                echo json_encode(["error" => "unAuth User"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["error" => "unKnown User"]);
        }
    }

    public function getInteractionsFiles()
    {
        $api = new Api();
        $headers = getallheaders();
        if (isset($headers["tkn"])) {
            $tkn = $headers["tkn"];
            if (Session::getSession("user_token") == $tkn) {
                $user = new User();
                $photo = new Photo();
                $filter = ["user_token" => $tkn];
                $userData = $user->selectOne($filter);
                $images = [];
                $filterLoved = ["_id" => new ObjectID($userData->loved[0])];
                $filterSaved = ["_id" => new ObjectID($userData->saved[0])];
                $filterUploadPhoto = ["user_id" => $userData->_id];
                $images[] = $photo->selectOne($filterLoved);
                $images[] = $photo->selectOne($filterSaved);
                $images[] = $photo->selectOne($filterUploadPhoto);
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
    public function showAllSaved()
    {
        apiProfileController::showPhotoProfile("saved");
    }
    public function showAllUploaded()
    {
        $api = new Api();
        $headers = getallheaders();
        if (isset($headers["tkn"])) {
            $tkn = $headers["tkn"];
            if ($tkn == Session::getSession("user_token")) {
                $user = new User();
                $photo = new Photo();
                $userFilter = ["user_token" => $tkn];
                $userData = $user->selectOne($userFilter);
                $photoFilter = ["user_id"=>$userData->_id];
                $photos = $photo->selectMany($photoFilter);

                http_response_code(200);
                echo json_encode( $photos);

            } else {
                http_response_code(404);
                echo json_encode(["error" => "unAuth User"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["error" => "unKnown User"]);
        }
    }
}
