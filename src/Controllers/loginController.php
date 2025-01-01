<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Redirect;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Classes\Session;
use Rizk\Kolala\Classes\Validation\Email;
use Rizk\Kolala\Classes\Validation\Exists;
use Rizk\Kolala\Classes\Validation\Required;
use Rizk\Kolala\Classes\Validation\Validation;
use Rizk\Kolala\Classes\View;
use Rizk\Kolala\Models\User;

class loginController{
    public function __construct()
    {
        session_start();
    }
    public function loginPage(){
        Session::csrfToken("csrf_login");
        View::render("login.php");
    }
    public function createAdmin(){
        $user = new User;
        $count = $user->insert([
            "email" => "ruk.ussef@gmail.com",
            "password"=> password_hash("123456",PASSWORD_DEFAULT),
            "role"=>"admin"
        ]);
        if($count>0){
            Session::setSession("success","welcome Login to access the Dashboard");
            Redirect::toLogin();
        }
    }

    public function loginHandle() {
        if(Request::checkPostExist('submit')){
            echo Request::post("csrf_login") == Session::getSession('csrf_login');
            if(Request::checkPostExist("csrf_login") && Request::post("csrf_login") == Session::getSession('csrf_login')){
                $vaild = new Validation;
                $user = new User;
                $email = Request::post("email");
                $password = Request::post("password");
                $vaild->vaildate("email",$email,[Required::class,Email::class,Exists::class]);
                $vaild->vaildate("password",$password,[Required::class]);
                $errors =$vaild->getErrors();
                if(empty($errors)){
                    $user_db = $user->selectOne(["email"=>$email]);
                    if(password_verify($password,$user_db->password)){
                        $user_token = bin2hex(random_bytes(32));
                        $update_result = $user->update(["email"=>$email],['$set'=>["user_token"=>$user_token]]);
                        if($update_result > 0){
                            Session::setSession("user_token",$user_token);
                            Session::setSession("success","welcome");
                            Redirect::toUpload();
                        }else{
                            Session::setSession("error","try again error happened");
                            Redirect::toLogin();
                        }
                    }else{
                        Session::setSession("error","wrong creditionals");
                        Redirect::toLogin();
                    }
                }else{
    
                    Session::setSession("errors",$errors);
                    Redirect::toLogin();
                }
            }else{
                Session::setSession("error","someting wrong bghdgfkjsbkjgasbk");
                Redirect::toLogin();
            }
        }else{
            Session::setSession("error","acces denied");
            Redirect::toLogin();
        }
    }
}