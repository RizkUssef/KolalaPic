<?php

namespace Rizk\Kolala\Classes\Validation;

use Rizk\Kolala\Classes\Validation\Vaildator;

class Required implements Vaildator{
    public function check($key,$value){
        if(empty($value)){
            return "$key is required";
        }else{
            return false;
        }
    }
}