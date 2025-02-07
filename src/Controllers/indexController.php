<?php

namespace Rizk\Kolala\Controllers;

use Rizk\Kolala\Classes\View;

class indexController{

    public function indexPage(){
        View::render('index.php');
    }
}