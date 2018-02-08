<?php require 'pagination/pod.pagin.php';?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Podcasts</title>
        <?php require 'templates/head.part.php';?>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
        <?php
            $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;
            switch($message) {
                case '/podcast_deleted':
                    echo '<h4 class="success">Podcast has been deleted.</h4>'; 
                    break;
            }

            echo $list;?>

            <?php if ($host_ok === true):?>
                <a href="add_podcast.php" class="add-material"></a>
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