<?php require 'pagination/stories.pagin.php';?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Stories</title>
        <?php require 'templates/head.part.php';?>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
            <?php
                $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;
                switch($message) {
                    case '/story_deleted':
                        echo '<h4 class="success">Story has been deleted.</h4>'; 
                        break;
                }

                echo $list;?>

            <?php if ($writer_ok === true):?>
                <a href="add_story.php" class="add-material"></a>
            <?php endif;?>
            
            <!-- Pagination -->
            <div  class="pagination">
                <div id="pagination_controls">
                    <?php echo $pagination_controls;?>
                </div>
            </div>

        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>