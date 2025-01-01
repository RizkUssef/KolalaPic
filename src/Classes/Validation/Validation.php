<?php

namespace Rizk\Kolala\Classes\Validation;
require 'Validator.php';
use Rizk\Kolala\Classes\Validation\Vaildator;
 

class Validation{
    private $errors = [];
    public function vaildate($key,$value,$rules){
        foreach ($rules as $rule) {
            $objectRule = new $rule;
            $error=$objectRule->check($key,$value);
            if ($error != false) {
                $this->errors[] = $error;
            }
        }
    }

    public function getErrors(){
        return $this->errors;
    }
}