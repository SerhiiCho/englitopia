<?php

require 'includes/check.inc.php';
check_member();

if ($writer_ok === false){
    header('Location: redirect.php?message=/error');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add new story</title>
        <?php require 'templates/head.part.php';?>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
            <!--Intro-->
            <div class="intro">
                <h1>Add new story</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis repellendus magnam exercitationem reprehenderit. Dolorem, a! Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit laboriosam, odit tenetur ad a excepturi ipsum quisquam voluptates nam facilis!</p>
                <hr>
            </div>
            <div class="wrapper-small2">
                <form method="POST" action="includes/add_story.inc.php" enctype='multipart/form-data' class="form">

                    <!-- Subject -->
                    <span class="span-form">Subject</span>
                    <input type="name" name="subject" onkeyup="counter(this,40,'message_title');" placeholder="Subject ...">
                    <div id="message_title"></div>

                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">

                    <!-- Intro -->
                    <textarea name="intro" onkeyup="counter(this, 207,'intro_text');" placeholder="Intro ..."></textarea>
                    <div id="intro_text"></div>

                    <!-- Text -->
                    <textarea name="text" onkeyup="counter(this, 10000,'message_status');" placeholder="Story ..." style="height: 400px;"></textarea>
                    <div id="message_status"></div>

                    <!-- Tags -->
                    <span class="span-form">Tags</span>
                    <input type="name" name="tags" onkeyup="counter(this, 1000,'story_tags');" placeholder="example 1, example 2, etc..">
                    <div id="story_tags"></div>

                    <!-- Author -->
                    <span class="span-form">Author</span>
                    <input type="name" name="author" onkeyup="counter(this,128,'story_author');" placeholder="John Doe">
                    <div id="story_author"></div>

                    <!-- Image -->
                    <span class="span-form">Choose an image</span>
                    <input type='file' name='file' id="notif_upload_img">
                    
                    <button type="submit" name="publish" class="button">Publish</button>
                </form>
            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>