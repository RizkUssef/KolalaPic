<?php

namespace Rizk\Kolala\Classes\Validation;

// use Rizk\Kolala\Classes\Validation\Vaildator;

class FileSize implements Vaildator {
    public function check($key,$value){
        if($value > 5){
            return "$key must be less than 5 MB";
        }else{
            return false;
        } 
    }
}