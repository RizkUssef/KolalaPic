<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Redirect;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Classes\Session;
use Rizk\Kolala\Classes\Validation\Validation;
use Rizk\Kolala\Models\User;

class apiLoginController
{
    protected $api;
    public function __construct()
    {
        session_start();
        $this->api = new Api;
    }

    public function loginCsrf()
    {
        $api = new Api;
        Session::csrfToken('csrf_login');
        echo json_encode(['csrf_login' => Session::getSession('csrf_login')]);
    }

    public function loginHandle()
    {
        if (strtoupper(Request::Method()) === "POST") {
            $api = new Api;
            $vaild = new Validation;
            $csrf_login = Session::getSession('csrf_login');
            $inputJSON = file_get_contents("php://input");
            $data = json_decode($inputJSON, true);
            $email = $data["email"];
            $user = new User;
            $db_data = $user->selectOne(["email" => $email]);
            $password = $data["password"];
            if (password_verify($password, $db_data['password'])) {
                http_response_code(200);
                Session::csrfToken('user_token');
                echo json_encode(['user_token' =>Session::getSession('user_token')]);
            } else {
                http_response_code(404); 
                echo json_encode("wrong creditional");
            }
        } else {
            http_response_code(404);
            echo json_encode("access denied");
        }
    }
}
