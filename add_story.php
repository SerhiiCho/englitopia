<?php

require_once('includes/check.inc.php');
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
        <?php require_once('templates/head.part.php');?>
    </head>
        <?php require_once('templates/nav.part.php');?>
    <body>
        <div class="wrapper">
            <!--Intro-->
            <div class="intro">
                <h1>Add new story</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis repellendus magnam exercitationem reprehenderit. Dolorem, a! Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit laboriosam, odit tenetur ad a excepturi ipsum quisquam voluptates nam facilis!</p>
                <hr>
            </div>
            <?php
                $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;
                switch($message) {
                    case '/there_is_an_unproved_story':
                        echo '<h4 class="error">There is already one unpproved story, you can\'t add another one.</h4>'; 
                        break;
                    case '/the_only_field_that_can_be_empty_is_tags':
                        echo '<h4 class="error">The only field that can be empty is "tags".</h4>'; 
                        break;
                    case '/subject_max_40_intro_max_207_author_max_128_charecters':
                        echo '<h4 class="error">Subject should be maximum 40 charecters, intro 207 charecters and athor 128.</h4>'; 
                        break;
                    case '/text_max_10000_charecters':
                        echo '<h4 class="error">Text should be maximum 10000 charecters.</h4>'; 
                        break;
                    case '/image_error':
                        echo '<h4 class="error">There is an error with the image you uploaded.</h4>'; 
                        break;
                    case '/only_jpg_allowed':
                        echo '<h4 class="error">Only jpg allowed.</h4>'; 
                        break;
                    case '/image_is_to_big':
                        echo '<h4 class="error">Image is too big, 1 Mb maximum.</h4>'; 
                        break;
                    case '/success':
                        echo '<h4 class="success">Thank you for adding story. Now go to stories and "approve" this if you don\'t see any mistakes, or "reject" if you want to cancel posting that. Anyway, in order to make it available for all users, it needs to be approved by 2 admins or writers.</h4>'; 
                        break;
                }
            ?>
            <div class="wrapper-small2">
                <form method="POST" action="includes/add_story.inc.php" enctype='multipart/form-data' class="form">

                    <!-- Subject -->
                    <span class="span-form">Subject</span>
                    <input type="text" name="subject" onkeyup="countCharsInTextfield(this,40,'message_title');" placeholder="Subject ..." required>
                    <div id="message_title" class="original"></div>

                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">

                    <!-- Intro -->
                    <textarea name="intro" onkeyup="countCharsInTextfield(this, 207,'intro_text');" placeholder="Intro ..." autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" required></textarea>
                    <div id="intro_text" class="original"></div>

                    <!-- Text -->
                    <textarea name="text" onkeyup="countCharsInTextfield(this, 10000,'message_status');" placeholder="Story ..." autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" required></textarea>
                    <div id="message_status" class="original"></div>

                    <!-- Tags -->
                    <span class="span-form">Tags</span>
                    <input type="text" name="tags" onkeyup="countCharsInTextfield(this, 1000,'story_tags');" value="story, ">
                    <div id="story_tags" class="original"></div>

                    <!-- Author -->
                    <span class="span-form">Author</span>
                    <input type="text" name="author" onkeyup="countCharsInTextfield(this,128,'story_author');" placeholder="John Doe" required>
                    <div id="story_author" class="original"></div>

                    <!-- Image -->
                    <span class="span-form">Choose an image</span>
                    <input type='file' name='file' id="notif-upload-img" required>
                    
                    <button type="submit" name="publish" class="button">Publish</button>
                </form>
            </div>
        </div>
        <?php require_once('templates/script_bottom.part.php');?>
    </body>
    <?php require_once('templates/footer.part.php');?>
</html>