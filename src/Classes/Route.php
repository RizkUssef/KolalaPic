<?php

namespace Rizk\Kolala\Classes;

class Route
{
    private $url, $method, $controller;

    public function __construct()
    {
        $this->parseUrl();
        $this->callMethod();
    }

    public function parseUrl()
    {
        $this->url = Request::Url();
        $public_pos = strpos($this->url, "/public");
        $after_public = ($public_pos != false) ? substr($this->url, $public_pos + strlen("/public/")) : false;
        if ($after_public != false) {
            $controller_method = explode("/", $after_public);
            $this->controller = $controller_method[0] . "Controller";
            $has_querystring = strpos($controller_method[1], "?");
            if ($has_querystring != false) {
                $method_parts  = explode("?", $controller_method[1]);
                $this->method = $method_parts[0];
            } else {
                $this->method = $controller_method[1];
            }
        }
    }

    public function callMethod()
    {
        $controller_with_namespace = "Rizk\Kolala\Controllers\\" . $this->controller;
        // if(class_exists($controller_with_namespace)){
        //     $object = new $controller_with_namespace;
        //     if(method_exists($object,$this->method)){
        //         call_user_func([$object,$this->method]);
        //     }else{
        //         die("method dosen't exist");
        //     }
        // }else{
        //     die("class dosen't exist");
        // }
        // ? turnary version :-
        (class_exists($controller_with_namespace))
            ? ((method_exists($object = new $controller_with_namespace, $this->method))
                ? (call_user_func([$object, $this->method]))
                : die("method dosen't exist"))
            : die("class dosen't exist");
    }
}
