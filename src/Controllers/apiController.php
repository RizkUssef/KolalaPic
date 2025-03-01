<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;

class apiController
{
    protected $api;
    
    public function __construct()
    {
        session_start();
        $this->api = new Api;
    }

}
