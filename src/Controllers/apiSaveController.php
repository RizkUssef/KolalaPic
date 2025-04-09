<?php

namespace Rizk\Kolala\Controllers;

class apiSaveController{
    public function __construct()
    {
        session_start();
    }
    public function save()
    {
        apiUserInteractions::UserInteractions("saved", "save", "saved");
    }
}