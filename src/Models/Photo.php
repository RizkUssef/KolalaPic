<?php

namespace Rizk\Kolala\Models;

use Rizk\Kolala\Classes\MongoDB;

class Photo extends MongoDB{
    public function setCollectionName(): string
    {
        return "photos";
    }
}