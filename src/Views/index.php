<?php

use Rizk\Kolala\Classes\Session;

require 'inc/header.php';
require 'inc/loader.php';
require 'inc/nav.php';
?>
    <?php require 'inc/session.php' ?>
    <section class="w-1/2  mx-auto dark:bg-dark-blur  bg-blur drop-shadow-main backdrop:blur-xl p-10 rounded-xl ">
        <div>
            <form action="http://localhost/KolalaPic/public/upload/uploadHandle" method="post" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo Session::getSession('csrf_upload') ?>" name="csrf_upload">

                <label class="text-2xl dark:text-bg text-primary" for=""> File Name</label>
                <input class="input dark:bg-primary" type="text" name="title" id="">

                <label class="text-2xl dark:text-bg text-primary" for="">File</label>
                <input type="file" name="image" class="input dark:bg-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 dark:file:bg-secondary dark:file:text-primary file:text-xs file:font-semibold file:bg-primary file:text-secondary cursor-pointer file:cursor-pointer hover:file:bg-violet-100 bg-[#fff]">

                <label class="text-2xl dark:text-bg text-primary" for="">Auther</label>
                <input class="input dark:bg-primary" type="text" name="auther" id="">

                <label class="text-2xl dark:text-bg text-primary" for="">Sub Category</label>
                <input class="input dark:bg-primary" type="text" name="subcategory" id="" value="Falcon">
                
                <label class="text-2xl dark:text-bg text-primary" for="">Description</label>
                <textarea class="input dark:bg-primary" name="description" id=""></textarea>

                <label class="text-2xl dark:text-bg text-primary" for="">Category</label>
                <select class="input dark:bg-primary selection:bg-secondary" name="category" id="">
                    <option selected value="animals">animals</option>
                    <option value="calm">calm</option>
                    <option value="couples">couples</option>
                    <option value="dark">dark</option>
                    <option value="football">football</option>
                </select>

                <button class="bg-primary dark:bg-secondary dark:text-primary text-secondary rounded-md mt-4 text-xl float-end  px-10 py-2" type="submit" name="submit">Upload</button>
                <div class="clear-both"></div>
            </form>
        </div>
    </section>
<?php require 'inc/footer.php' ?>