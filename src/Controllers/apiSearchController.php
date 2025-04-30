<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Classes\Response;
use Rizk\Kolala\Classes\Session;
use Rizk\Kolala\Models\Photo;
use Rizk\Kolala\Models\User;

class apiSearchController
{
    public function __construct()
    {
        session_start();
    }
    public function SearchHandle()
    {
        $api = new Api;
        $headers = getallheaders();
        if (strtoupper(Request::Method()) === "POST") {
            if (isset($headers["tkn"])) {
                $tkn = $headers["tkn"];
                if (Session::getSession("user_token") == $tkn) {
                    $jsonInput = file_get_contents("php://input");
                    $data = json_decode($jsonInput, true);
                    $photo = new Photo;
                    $filtered_text = strtolower($data["search_input"]);
                    $photo_filter = [
                        '$or' => [
                            ["subcategory" => $filtered_text], 
                            ["category" => $filtered_text], 
                            ["auther" => $filtered_text]
                        ]
                    ];
                    echo ($api->all(Photo::class, $photo_filter));

                    // Response::msg(["success" => $photoDB], 200);
                } else {
                    Response::msg(["error" => "unAuth User"], 404);
                }
            } else {
                Response::msg(["error" => "unknown User"], 404);
            }
        } else {
            Response::msg(["error" => "access denied"], 404);
        }
    }
}
