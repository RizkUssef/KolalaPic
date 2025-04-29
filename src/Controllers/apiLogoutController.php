<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Classes\Session;
use Rizk\Kolala\Models\User;

class apiLogoutController extends apiController{
    public function logout(){
        $api = new Api;
        if(Request::checkGetExist("tkn")){
            if(Session::checkSessionExist("user_token")){
                $user_token = Request::get("tkn");
                $user = new User;
                $filter = ["user_token"=>$user_token];
                $update = ['$set' =>["user_token"=>null]];
                $user->update($filter,$update);
                Session::removeSession("user_token");
                http_response_code( 200);
                echo json_encode(["success"=>"you're logged out successfully"]);
            }else{
                http_response_code(404);
                echo json_encode(["error"=>"you're already logged out"]);
            }
        }else{
            http_response_code(404);
            echo json_encode(["error"=>"unkown user"]);
        }
    }

    public function checkAuth(){
        $api = new Api;
        $user = new User;
        $headers = getallheaders();
        if(isset($headers["tkn"])){
            $tkn = $headers["tkn"];
            if(Session::checkSessionExist("user_token")){
                if(Session::getSession("user_token")==$tkn){
                    http_response_code(200);
                    echo json_encode(["Auth"=>true]);
                }else{
                    http_response_code(404);
                    echo json_encode(["error"=>"unAuth User"]);
                }
            }else{
                $userFilter = ["user_token"=>$tkn];
                $user->update($userFilter,['$set'=>["user_token"=>null]]);
                http_response_code(200);
                echo json_encode(["Auth"=>false]); 
            }
        }else{
            http_response_code(404);
            echo json_encode(["error"=>"you must login first"]); 
        }
    }
}