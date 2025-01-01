<?php

namespace Rizk\Kolala\Classes\Validation;

use Rizk\Kolala\Classes\Validation\Vaildator;
use Rizk\Kolala\Models\User;

class Exists implements Vaildator{
    public function check($key, $value)
    {
        $userObject = new User; //user is model
        $filter = ["email"=>$value];
        $user=$userObject->selectOne($filter);
        if($user == null){
            return "wrong creditionals  mail";
        }else{
            return false;
        }
    }
}