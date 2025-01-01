<?php

use Rizk\Kolala\Classes\Session;

require 'inc/header.php';
require 'inc/loader.php';
require 'inc/nav.php';
?>

<h1 class="text-[50px] text-primary text-center dark:text-bg mb-10">Login</h1>
<?php require 'inc/session.php' ?>
<section class="w-1/2  mx-auto dark:bg-dark-blur  bg-blur drop-shadow-main backdrop:blur-xl p-10 pt-4 rounded-xl ">
    <div>
        <form action="http://localhost/KolalaPic/public/login/loginHandle" method="post">
            <input name="csrf_login" type="hidden" value="<?php echo Session::getSession("csrf_login") ?>">
            <label class="text-2xl dark:text-bg text-primary" for="">Email</label>
            <input class="input dark:bg-primary" type="email" name="email" id="">
            <label class="text-2xl dark:text-bg text-primary" for="">Password</label>
            <input class="input dark:bg-primary" type="password" name="password" id="">
            <button class="bg-primary dark:bg-secondary dark:text-primary text-secondary rounded-md mt-4 text-xl float-end  px-10 py-2" type="submit" name="submit">Submit</button>
            <div class="clear-both"></div>
        </form>
    </div>
</section>
<?php
require 'inc/footer.php'
?>