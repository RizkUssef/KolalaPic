<?php

namespace Rizk\Kolala\Classes;

class View{
    public static function render($fileName,$data=[]){
        $path = "C:/xampp/htdocs/KolalaPic/src/Views/".$fileName;
        if(file_exists($path)){
            extract($data);
            include($path);
        }else{
            die("file doesn't exist");
        }
    }
}