<?php

namespace Rizk\Kolala\Classes\Validation;

use Rizk\Kolala\Classes\Validation\Vaildator;

class FileExtension implements Vaildator {
    public function check($key,$value){
        $allowedExetension = ["png","jpg","jpeg","gif"];
        if(!in_array($value,$allowedExetension)){
            return "$key is not allowed";
        }else{
            return false;
        }
    }
}