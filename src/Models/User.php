<?php

namespace Rizk\Kolala\Models;

use Rizk\Kolala\Classes\MongoDB;

class User extends MongoDB{
    public function setCollectionName(): string
    {
        return "users";
    }
}