<?php

namespace Rizk\Kolala\Classes;

class Redirect
{
    public function __construct()
    {
        session_start();
    }
    public static function toUpload()
    {
        Header::goTo("http://localhost/KolalaPic/public/upload/uploadPage");
    }
    public static function toLogin()
    {
        Header::goTo("http://localhost/KolalaPic/public/login/loginPage");
    }
    public static function toCreate()
    {
        Session::csrfToken("csrf_create");
        Header::goTo("http://localhost/blog%20to%20try/public/create/createPage");
    }
    public static function toIndex(){
        Header::goTo("http://localhost/blog%20to%20try/public/index/indexPage");
    }
}
