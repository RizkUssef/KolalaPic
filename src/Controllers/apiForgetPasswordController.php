<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Classes\Response;
use Rizk\Kolala\Classes\SendEmail;
use Rizk\Kolala\Classes\Session;
use Rizk\Kolala\Classes\View;
use Rizk\Kolala\Models\User;

class apiForgetPasswordController
{
    public function __construct()
    {
        session_start();
    }
    public function csrfForget()
    {
        $api = new Api;
        Session::csrfToken("csrf_forget_password");
        echo json_encode(["csrf" => Session::getSession("csrf_forget_password")]);
    }
    public function csrfReset()
    {
        $api = new Api;
        Session::csrfToken("csrf_reset_password");
        echo json_encode(["csrf" => Session::getSession("csrf_reset_password")]);
    }
    public function forgetPasswordHandle()
    {
        $api = new Api;
        $headers = getallheaders();
        if (strtoupper(Request::Method()) === "POST") {
            if (isset($headers["tkn"])) {
                $tkn = $headers["tkn"];
                if (Session::getSession("user_token") == $tkn) {
                    $user = new User;
                    $userFilter = ["user_token" => $tkn];
                    $userDB = $user->selectOne($userFilter);
                    $inputJSON = file_get_contents("php://input");
                    $data = json_decode($inputJSON, true);
                    $email = $data["email"];
                    $forget_csrf = $data["csrf_forget"];
                    if (Session::getSession("csrf_forget_password") == $forget_csrf) {
                        // Session::csrfToken("reset_password");
                        SendEmail::sendEmail($email);
                        http_response_code(200);
                        echo json_encode(["success" => "check your email"]);
                    } else {
                        http_response_code(404);
                        echo json_encode(["error" => "unAuth way to access"]);
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "unAuth User"]);
                }
            } else {
                http_response_code(404);
                echo json_encode(["error" => "unknown User"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["error" => "access denied"]);
        }
    }

    public function resetPasswordHandle()
    {
        $api = new Api;
        $headers = getallheaders();
        if (strtoupper(Request::Method()) === "POST") {
            if (isset($headers["tkn"])) {
                $tkn = $headers["tkn"];
                if (Session::getSession("user_token") == $tkn) {
                    $jsonInput = file_get_contents("php://input");
                    $data = json_decode($jsonInput,true);
                    $user = new User;
                    $user_filter = ["user_token"=>$tkn];
                    if(Session::getSession("csrf_reset_password")==$data["csrf_reset"]){
                        if($data["password"] == $data["confirm_password"]){
                            $userDB = $user->update($user_filter,['$set'=>["password"=>password_hash($data["password"],PASSWORD_DEFAULT)]]);
                            Response::msg(["success"=>"password reset successfully"],200);
                        }else{
                            Response::msg(["error"=>"unconfirmed password"],404);
                        }
                    }else{
                        Response::msg(["error"=>"unAuth way to access"],404);
                    }
                } else {
                    Response::msg(["error"=>"unAuth User"],404);
                }
            } else {
                Response::msg(["error"=>"unknown User"],404);
            }
        } else {
            Response::msg(["error"=>"access denied"],404);
        }
    }
}
