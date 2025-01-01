<?php

namespace Rizk\Kolala\Classes\Validation;

// use Rizk\Kolala\Classes\Vaildator;
use Rizk\Kolala\Classes\Validation\Vaildator;

class Str implements Vaildator {
    public function check($key,$value){
        if(is_numeric($value)){
            return "$key must be string";
        }else{
            return false;
        }
    }
}