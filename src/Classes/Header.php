<?php

namespace Rizk\Kolala\Classes;

class Header{
    public static function goTo($path){
        header("location:$path");
        exit;
    }
}