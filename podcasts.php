<?php require 'pagination/pod.pagin.php';?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Podcasts</title>
        <?php require_once('templates/head.part.php');?>
    </head>
        <?php require_once('templates/nav.part.php');?>
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
                <a href="add_podcast.php" class="fas fa-plus-circle add-material"></a>
            <?php endif;?>

            <!-- Pagination -->
            <div  class="pagination">
                <?php echo $pagination_controls;?>
            </div>

        </div>
        <?php require_once('templates/script_bottom.part.php');?>
    </body>
    <?php require_once('templates/footer.part.php');?>
</html>