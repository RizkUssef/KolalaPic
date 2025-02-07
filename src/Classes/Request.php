<?php

namespace Rizk\Kolala\Classes;

class Request
{
    public static function checkGetExist($key)
    {
        return isset($_GET[$key]) ? true : false;
    }
    public static function checkPostExist($key)
    {
        return isset($_POST[$key]) ? true : false;
    }
    public static function checkGetEmpty($key)
    {
        return Request::checkGetExist($key) ? (empty($_GET[$key]) ? true : false) : false;
    }
    public static function checkPostEmpty($key)
    {
        return Request::checkGetExist($key) ? (empty($_POST[$key]) ? true : false) : false;
    }
    public static function get($key)
    {
        return Request::checkGetExist($key) ? (Request::checkGetEmpty($key) ? false : $_GET[$key])  : false;
    }
    public static function post($key)
    {
        return Request::checkPostExist($key) ? (Request::checkPostEmpty($key) ? false : $_POST[$key])  : false;
    }
    public static function clearInput($input)
    {
        return htmlspecialchars(trim(strtolower($input)));
    }
    public static function queryString()
    {
        return $_SERVER["QUERY_STRING"];
    }
    public static function Url()
    {
        return $_SERVER["REQUEST_URI"];
    }
    public static function Method()
    {
        return $_SERVER["REQUEST_METHOD"];
    }
}
