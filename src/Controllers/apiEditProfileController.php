<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Files;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Classes\Session;
use Rizk\Kolala\Classes\Validation\FileExtension;
use Rizk\Kolala\Classes\Validation\FileSize;
use Rizk\Kolala\Classes\Validation\Required;
use Rizk\Kolala\Classes\Validation\Str;
use Rizk\Kolala\Classes\Validation\Validation;
use Rizk\Kolala\Models\User;

class apiEditProfileController extends apiController
{
    public function __construct()
    {
        session_start();
    }
    public function editProfileCsrf()
    {
        $api = new Api;
        Session::csrfToken('csrf_editProfile');
        echo json_encode(['csrf' => Session::getSession('csrf_editProfile')]);
    }
    public function editProfile()
    {
        $api = new Api;
        $headers = getallheaders();
        if (strtoupper(Request::Method()) == "POST") {
            if (isset($headers["tkn"])) {
                $user = new User;
                $tkn = $headers["tkn"];
                if (Session::getSession("user_token") == $tkn) {
                    $filterUser = ["user_token" => $tkn];
                    $vaild = new Validation;
                    $file = new Files("user_image");
                    // recive
                    $name = Request::post("name");
                    // vaildate
                    $vaild->vaildate("name", $name, [Str::class, Required::class]);
                    if ($file->checkFile()) {
                        $image_name = $file->getFileData("name");
                        $tmp_name = $file->getFileData("tmp_name");
                        $image_size = $file->getFileData("size");
                        $ext = $file->getExt("$image_name");
                        $size_mb = $file->sizeMB($image_size);
                        $image_new_name = $file->setNewFileName($ext);
                        // vaildate
                        $vaild->vaildate("image size", $size_mb, [FileSize::class]);
                        $vaild->vaildate("ext", $ext, [FileExtension::class]);
                        $errors = $vaild->getErrors();
                        if (empty($errors)) {
                            // $user_filter = ["user_token"=>$tkn]
                            $userDB = $user->selectOne($filterUser);
                            // $user_img_path = "C:/xampp/htdocs/KolalaPic/public/uploads/Users";
                            $user_img = "Users/".$userDB->image;
                            if($file->checkFileExists($user_img)){
                                $file->deleteImage($user_img);
                                $file->storeFile($tmp_name,"Users/".$image_new_name);
                            }else{
                                $file->storeFile($tmp_name,"Users/".$image_new_name);
                            }
                            $doc = ["name"=>$name,"image"=>$image_new_name];
                            $user->update($filterUser, ['$set' => $doc]);
                            http_response_code(200);
                            echo json_encode(["success" => "Your Data Updated Successfully"]);
                        } else {
                            http_response_code(404);
                            echo json_encode(["error" => $errors]);
                        }
                    } else {
                        // no file
                        $doc = ["name"=>$name];
                        $user->update($filterUser, ['$set' => $doc]);
                        http_response_code(200);
                        echo json_encode(["success" => "Your Data Updated Successfully"]);
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "unAuth User"]);
                }
            } else {
                http_response_code(404);
                echo json_encode(["error" => "unKnown User"]);
            }
        } else {
        }
    }
}
