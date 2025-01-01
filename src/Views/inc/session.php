<?php

use Rizk\Kolala\Classes\Session;

if (Session::checkSessionExist('error')): ?>
    <div class="w-1/2 mx-auto bg-error p-4 pl-5 rounded-md text-secondary">
        <h1><?php print_r(Session::getSession('error')) ?></h1>
    </div>
<?php endif;
Session::removeSession("error");
?>
<?php if (Session::checkSessionExist('errors')): ?>
    <div class="w-1/2 mx-auto bg-error rounded-md p-4 text-secondary">
        <?php foreach (Session::getSession('errors') as $error): ?>
                <h1><?php echo $error ?></h1>
        <?php endforeach; ?>
    </div>
    <?php Session::removeSession("errors");
    ?>

<?php endif ?>
<?php if (Session::checkSessionExist('success')): ?>
    <div class="w-1/2 mx-auto bg-primary p-4 rounded-md text-secondary">
        <h1><?php echo Session::getSession('success') ?></h1>
    </div>
<?php endif;
Session::removeSession("success");
?>