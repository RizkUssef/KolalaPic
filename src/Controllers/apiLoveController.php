<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\Api;
use Rizk\Kolala\Classes\Request;
use Rizk\Kolala\Models\Photo;
use MongoDB\BSON\ObjectID;
use Rizk\Kolala\Models\User;

class apiLoveController
{
    public function __construct()
    {
        session_start();
    }
    public function love()
    {
        apiUserInteractions::UserInteractions("loved", "love", "loved");
    }
}
