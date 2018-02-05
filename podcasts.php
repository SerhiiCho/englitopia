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
 
            <?php echo $list;?>

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