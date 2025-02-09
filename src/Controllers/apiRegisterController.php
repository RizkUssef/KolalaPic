<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Classes\Session;
use Rizk\Kolala\Classes\Validation\Email;
use Rizk\Kolala\Classes\Validation\Required;
use Rizk\Kolala\Classes\Validation\Str;
use Rizk\Kolala\Classes\Validation\Validation;
use Rizk\Kolala\Models\User;

class apiRegisterController extends apiController{
    
    public function registerCsrf()
    {
        $api = new Api;
        Session::csrfToken('csrf_register');
        echo json_encode(['csrf_register' => Session::getSession('csrf_register')]);
    }

    public function registerHandle()
    {
        if (strtoupper(Request::Method()) === "POST") {
            $api = new Api;
            $vaild = new Validation;
            $csrf_register = Session::getSession('csrf_register');
            $inputJSON = file_get_contents("php://input");
            $data = json_decode($inputJSON, true); // Convert JSON to PHP array[]
            $password = password_hash($data["password"], PASSWORD_DEFAULT);
            $password_confirmation = $data['password_confirmation'];
            if ($csrf_register == $data["csrf_register"]) {
                //     // ----vaildate
                $vaild->vaildate('name', $data["name"], [Required::class, Str::class]);
                $vaild->vaildate("email", $data["email"], [Required::class, Email::class]);
                $vaild->vaildate("password", $password, [Required::class]);
                $vaild->vaildate("password_confirmation", $password_confirmation, [Required::class]);
                $errors = $vaild->getErrors();
                $doc = [
                    "name" => $data["name"],
                    "email" => $data["email"],
                    "password" => $password,
                    "role" => "user",
                ];
                if (empty($errors)) {
                    if (password_verify($password_confirmation, $password)) {
                        http_response_code(200);
                        echo json_encode($api->insertUser(User::class, $doc));
                    } else {
                        http_response_code(404);
                        echo json_encode("password must be confirmed");
                    }
                } else {
                    http_response_code(404);
                    echo json_encode($errors);
                }
            } else {
                http_response_code(404);
                echo json_encode("unauthurized way to access");
            }
        } else {
            http_response_code(404);
            echo json_encode("access denied");
        }
    }
}