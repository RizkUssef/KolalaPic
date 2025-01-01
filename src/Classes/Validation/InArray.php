<?php

namespace Rizk\Kolala\Classes\Validation;

use Rizk\Kolala\Classes\Validation\Vaildator;

class InArray implements Vaildator{
    public function check($key,$value){
        $array = ["animals","calm","couples","dark","football"];
        if(!in_array($value,$array)){
            return "$key not in allowed category";
        }else{
            return false;
        }
    }
}