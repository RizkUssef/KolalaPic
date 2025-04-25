<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Models\Photo;
use Rizk\Kolala\Models\User;
use MongoDB\BSON\ObjectID;
use Rizk\Kolala\Classes\Session;

class apiUserInteractions
{
    public function __construct()
    {
        session_start();
    }

    public static function UserInteractions($interaction, $action, $msg)
    {
        $api = new Api;
        if (Request::checkGetExist("id")) {
            $headers = getallheaders();
            if (isset($headers['tkn'])) {
                $tkn = $headers['tkn'];
                $id = Request::get("id");
                $photo = new Photo;
                $user = new User;
                if($tkn == Session::getSession("user_token")) {
                    $filterUser = ["user_token" => $tkn];
                    $updateUser = ['$push' => [$interaction => new ObjectID($id)]];
                    $userData = $user->selectOne($filterUser);
                    $filterPhoto = ["_id" => new ObjectID($id)];
                    $photoData = $photo->selectOne($filterPhoto);
                    if (isset($photoData->$action) && isset($userData->$interaction)) {
                        if (!in_array(new ObjectID($id), (array)($userData->$interaction))) {
                            $count = $photoData->$action;
                            $update = ['$set' => [$action => $count + 1]];
                            $photo->update($filterPhoto, $update);
                            $user->update($filterUser, $updateUser);
                            http_response_code(200);
                            echo json_encode(["success" => $msg]);
                        } else {
                            http_response_code(404);
                            echo json_encode(["error" => "already $msg it"]);
                        }
                    } else {
                        $update = ['$set' => [$action => 1]];
                        $photo->update($filterPhoto, $update);
                        $user->update($filterUser, $updateUser);
                        http_response_code(200);
                        echo json_encode(value: ["success" => $msg]);
                    }
                }else{
                    http_response_code(404);
                    echo json_encode(["error" => "unknown user"]);
                }
            } else {
                http_response_code(404);
                echo json_encode(["error" => "unknown user"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["error" => "undefined photo"]);
        }
    }
}
