<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Classes\Session;
use Rizk\Kolala\Classes\Validation\Required;
use Rizk\Kolala\Classes\Validation\Validation;
use Rizk\Kolala\Models\User;

class apiChangePasswordController
{
    public function __construct()
    {
        session_start();
    }

    public function changePasswordCsrf()
    {
        $api = new Api;
        Session::csrfToken('csrf_change_password');
        echo json_encode(['csrf' => Session::getSession('csrf_change_password')]);
    }
    public function changePassword()
    {
        $api = new Api;
        $headers = getallheaders();
        if (isset($headers["tkn"])) {
            $tkn = $headers["tkn"];
            if (Session::getSession("user_token") == $tkn) {
                $user = new User;
                $vaild = new Validation;
                $user_filter = ["user_token" => $tkn];
                $userDB = $user->selectOne($user_filter);
                // recive
                $inputJSON = file_get_contents("php://input");
                $data = json_decode($inputJSON, true);
                // $old_pass = Request::post("old_password");
                // $new_pass = Request::post("new_password");
                // $confirm_pass = Request::post("confirm_password");
                // $csrf_change = Request::post("csrf_change_password");
                $old_pass=$data["old_password"];
                $new_pass=$data["new_password"];
                $confirm_pass=$data["confirm_password"];
                $csrf_change = $data["csrf_change_password"];

                // vaidation
                $vaild->vaildate("Old PassWord", $old_pass, [Required::class]);
                $vaild->vaildate("New PassWord", $new_pass, [Required::class]);
                $vaild->vaildate("Confirm PassWord", $confirm_pass, [Required::class]);

                $errors = $vaild->getErrors();
                if (empty($errors)) {
                    if (Session::getSession('csrf_change_password') == $csrf_change) {
                        if (password_verify($old_pass, $userDB->password)) {
                            if ($new_pass == $confirm_pass) {
                                $user->update($user_filter, ['$set' => ["password" => password_hash($new_pass, PASSWORD_DEFAULT)]]);
                                http_response_code(200);
                                echo json_encode(["success" => "Password Updated Successfully"]);
                            } else {
                                http_response_code(404);
                                echo json_encode(["error" => "Unconfirmed Password"]);
                            }
                        } else {
                            http_response_code(404);
                            echo json_encode(["error" => "Wrong Password"]);
                        }
                    } else {
                        http_response_code(404);
                        echo json_encode(["error" => "Wrong way to access"]);
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => $errors]);
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
}
