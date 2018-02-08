<?php require 'pagination/info.pagin.php';?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Information</title>
        <?php require 'templates/head.part.php';?>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">

            <!-- Intro -->
            <br />
            <div class="intro">
                <h1>Information</h1>
                <p class="intro-text">Here we have some information that we want to share with you. Such as our thanks to people helped us through our way to that place.</p>
                <hr>
            </div>

            <!-- Information -->
            <div class="wrapper-small2">
                <?php echo $list;?>
            </div>

            <!-- Pagination -->
            <div  class="pagination">
                <div id="pagination_controls"><? echo $pagination_controls;?></div>
            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>