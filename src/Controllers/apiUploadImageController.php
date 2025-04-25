<?php 

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Files;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Classes\Session;
use Rizk\Kolala\Classes\Validation\Validation;

class apiUploadImageController{
    public function __construct(){
        session_start();
    }
    public function uploadCsrf()
    {
        $api = new Api;
        Session::csrfToken('csrf_upload');
        echo json_encode(['csrf' => Session::getSession('csrf_upload')]);
    }

    public function upload(){
        if(strtoupper(Request::Method())==="POST"){
            $api = new Api;
            $vaild = new Validation;
            $file = new Files("file");
            // echo ($file->getFileData("name"));
            if($file->checkFile()){

                $inputJSON = file_get_contents("php://input");
                // echo ($inputJSON);
                $data = json_decode($inputJSON, true);
                echo json_encode($data);
            }else{
                $inputJSON = file_get_contents("php://input");
                // echo ($inputJSON);
                $data = json_decode($inputJSON, true);
                echo json_encode($data);

            }
            // $csrf_upload = Session::getSession('csrf_upload');

            // echo "<pre>";
            // echo(json_encode($data));
            // // if($csrf_upload){

            // // }else{

            // // }
        }else{

        }
    }
}