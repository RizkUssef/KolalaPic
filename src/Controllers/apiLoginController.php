<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Redirect;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Classes\Session;
use Rizk\Kolala\Classes\Validation\Email;
use Rizk\Kolala\Classes\Validation\Exists;
use Rizk\Kolala\Classes\Validation\Required;
use Rizk\Kolala\Classes\Validation\Validation;
use Rizk\Kolala\Models\User;

class apiLoginController extends apiController
{
    public function loginCsrf()
    {
        $api = new Api;
        Session::csrfToken('csrf_login');
        echo json_encode(['csrf' => Session::getSession('csrf_login')]);
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
            if ($data["csrf_login"] == $csrf_login) {
                $vaild->vaildate("email", $data["email"], [Required::class, Email::class, Exists::class]);
                $vaild->vaildate("password", $password, [Required::class]);
                $errors = $vaild->getErrors();
                if (empty($errors)) {
                    if (password_verify($password, $db_data['password'])) {
                        http_response_code(200);
                        Session::csrfToken('user_token');
                        $filter = ["email" => $email]; 
                        $update = ['$set' => ["user_token" => Session::getSession('user_token')]];
                        $user->update($filter,$update);
                        echo json_encode(['user_token' => Session::getSession('user_token')]);
                    } else {
                        http_response_code(404);
                        echo json_encode(["error" => "wrong creditionals"]);
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => $errors]);
                }
            } else {
                http_response_code(404);
                echo json_encode(["error" => "unauthurized access"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["error" => "access denied"]);
        }
    }
}
