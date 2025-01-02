<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Files;
use Rizk\Kolala\Classes\Redirect;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Classes\Session;
use Rizk\Kolala\Classes\Validation\FileExtension;
use Rizk\Kolala\Classes\Validation\FileSize;
use Rizk\Kolala\Classes\Validation\InArray;
use Rizk\Kolala\Classes\Validation\Required;
use Rizk\Kolala\Classes\Validation\Str;
use Rizk\Kolala\Classes\Validation\Validation;
use Rizk\Kolala\Classes\View;
use Rizk\Kolala\Models\Photo;
use Rizk\Kolala\Models\User;

class uploadController
{
    public function __construct()
    {
        session_start();
    }
    public function uploadPage()
    {
        if (Session::checkSessionExist("user_token")) {
            $user = new User;
            $user_db = $user->selectOne(["user_token"=> Session::getSession("user_token")]);
            if ($user_db->role == "admin") {
                Session::csrfToken("csrf_upload");
                View::render("index.php");
            } else {
                Session::setSession("error", "who are you");
                Redirect::toLogin();
            }
        } else {
            Session::setSession("error", "you must login first");
            Redirect::toLogin();
        }
    }
    public function uploadHandle()
    {
        if (Session::checkSessionExist("user_token")) {
            $user = new User;
            $user_db = $user->selectOne(["user_token", Session::getSession("user_token")]);
            if ($user_db->role == "admin") {
                if (Request::checkPostExist("submit")) {
                    if (Request::checkPostExist("csrf_upload") && Request::post("csrf_upload") == Session::getSession('csrf_upload')) {
                        $vaild = new Validation;
                        $photo = new Photo;
                        $file = new Files("image");

                        $title = Request::clearInput(Request::post("title"));
                        $auther = Request::clearInput(Request::post("auther"));
                        $description = Request::clearInput(Request::post("description"));
                        $category = Request::clearInput(Request::post("category"));
                        $vaild->vaildate("title", $title, [Required::class, Str::class]);
                        $vaild->vaildate("auther", $auther, [Required::class, Str::class]);
                        $vaild->vaildate("description", $description, [Required::class, Str::class]);
                        $vaild->vaildate("category", $category, [Required::class, InArray::class]);
                        // file
                        if ($file->checkFile()) {
                            $file_name = $file->getFileData("name");
                            $file_size = $file->getFileData("size");
                            $file_tmp_name = $file->getFileData("tmp_name");
                            $file_ext = $file->getExt($file_name);
                            $file_size_mb = $file->sizeMB($file_size);
                            $file_new_name = $file->setNewFileName($file_ext);
                            $vaild->vaildate("file", $file_size_mb, [FileSize::class]);
                            $vaild->vaildate("file", $file_ext, [FileExtension::class]);
                            $errors = $vaild->getErrors();
                            if (empty($errors)) {
                                $file->storeFile($file_tmp_name, $file_new_name);
                                $insert_result = $photo->insert([
                                    "title" => $title,
                                    "auther" => $auther,
                                    "description" => $description,
                                    "category" => $category,
                                    "file" => $file_new_name
                                ]);
                                if ($insert_result > 0) {
                                    Session::setSession("success", "Data Inserted Successfully");
                                    Redirect::toUpload();
                                } else {
                                    Session::setSession("error", "ummm error while uploading");
                                    Redirect::toUpload();
                                }
                            } else {
                                Session::setSession("errors", $errors);
                                Redirect::toUpload();
                            }
                        } else {
                            Session::setSession("error", "bro it's fucken pic project upload any pic or video");
                            Redirect::toUpload();
                        }
                    } else {
                        Session::setSession("error", "ah ah wrong way");
                        Redirect::toUpload();
                    }
                } else {
                    Session::setSession("error", "access denied");
                    Redirect::toUpload();
                }
            } else {
                Session::setSession("error", "who are you");
                Redirect::toLogin();
            }
        } else {
            Session::setSession("error", "you must login first");
            Redirect::toLogin();
        }
    }
}
