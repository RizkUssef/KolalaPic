<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Files;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Classes\Session;
use Rizk\Kolala\Classes\Validation\FileExtension;
use Rizk\Kolala\Classes\Validation\FileSize;
use Rizk\Kolala\Classes\Validation\InArray;
use Rizk\Kolala\Classes\Validation\Required;
use Rizk\Kolala\Classes\Validation\Str;
use Rizk\Kolala\Classes\Validation\Validation;
use Rizk\Kolala\Models\Photo;
use Rizk\Kolala\Models\User;

class apiUploadImageController
{
    public function __construct()
    {
        session_start();
    }
    public function uploadCsrf()
    {
        $api = new Api;
        Session::csrfToken('csrf_upload');
        echo json_encode(['csrf' => Session::getSession('csrf_upload')]);
    }

    public function upload()
    {
        $api = new Api;
        $headers = getallheaders();
        if (strtoupper(Request::Method()) === "POST") {
            $user = new User();
            $photo = new Photo();
            if(isset($headers['tkn'])){
                $tkn = $headers['tkn'];
                if($tkn == Session::getSession('user_token')){
                    $upload_csrf = Request::post("upload_csrf");
                    if ($upload_csrf == Session::getSession("csrf_upload")) {
                        $vaild = new Validation;
                        $file = new Files("file");
                        // recive data
                        $fileName = Request::post("file_name");
                        $description = Request::post("description");
                        $auther = Request::post("auther");
                        $category = Request::post("category");
                        $sub_category = Request::post("sub_category");
                        // vaildate it
                        $vaild->vaildate("File Name", $fileName, [Str::class, Required::class]);
                        // $vaild->vaildate("Upload CSRF",$upload_csrf,[Str::class,Required::class]);
                        $vaild->vaildate("Description", $description, [Str::class, Required::class]);
                        $vaild->vaildate("Auther", $auther, [Str::class, Required::class]);
                        $vaild->vaildate("Category", $category, [InArray::class, Required::class]);
                        $vaild->vaildate("Sub Category", $sub_category, [Str::class, Required::class]);
                        // recive image
                        if ($file->checkFile()) {
                            $imgName = $file->getFileData("name");
                            $imgTmpName = $file->getFileData("tmp_name");
                            $imgSize = $file->getFileData("size");
                            $sizeMB = $file->sizeMB($imgSize);
                            $ext = $file->getExt($imgName);
                            // vaildate it
                            $vaild->vaildate("Image Size", $sizeMB, [FileSize::class]);
                            $vaild->vaildate("Image Ext", $ext, [FileExtension::class]);
                            // get error
                            $errors = $vaild->getErrors();
                            if (empty($errors)) {
                                $file->storeFile($imgTmpName,$imgName);
                                $userFilter = ["user_token"=>$tkn];
                                $userDB = $user->selectOne($userFilter);
                                $doc = [
                                    "title"=>$fileName,
                                    "auther"=>$auther,
                                    "description"=>$description,
                                    "category"=>$category,
                                    "subcategory"=>$sub_category,
                                    "file"=>$imgName,
                                    "user_id"=>$userDB->_id,
                                ];
                                $insertRes = $photo->insert($doc);
                                if ($insertRes) {
                                    http_response_code(200);
                                    echo json_encode(["success" => "Image Inserted successfully"]);
                                }else{
                                    http_response_code(404);
                                    echo json_encode(["error" => "error while uploading"]);
                                }
                            }else{
                                http_response_code(404);
                                echo json_encode(["error" => $errors]);
                            }
                        } else {
                            http_response_code(404);
                            echo json_encode(["error"=>"Waiting for your upload ..."]);
                        }
                    } else {
                        http_response_code(404);
                        echo json_encode(["error"=>"unauthurized way to access"]);
                    }
                }else{
                    http_response_code(404);
                    echo json_encode(["error"=>"UnAuth User"]);
                }
            }else{
                http_response_code(404);
                echo json_encode(["error"=>"You must Login first"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["error"=>"access denied"]);
        }
    }
}
