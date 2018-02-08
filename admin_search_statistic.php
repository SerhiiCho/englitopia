<?php

require 'pagination/search_statistic.pagin.php';
check_member();
check_admin();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'templates/head.part.php';?>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-settings{border-bottom:solid .125rem gray;}</style>
        <title>Search statistic</title>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
        	<?php require 'templates/profile_menu.part.php';?>

            <div class="intro">
                <h1>Search statistic</h1>
            </div>

            <div class="wrapper-member-table">
                <ul class="members-table-info">
                    <li><i class="fas fa-eye"></i> - How many times the word has been searched</li>
                </ul>
            </div>

            <h5 style="font-weight:bold;"><?php echo $text_line1;?></h5>
            <h5 style="font-weight:bold;"><?php echo $text_line2;?></h5>

            <div  class="pagination">
                <div id="pagination_controls"><?php echo $pagination_controls;?></div>
            </div>

            <hr>
            <table class="admin-table">
                <th>id</th>
                <th>Word</th>
                <th><i class="fas fa-eye"></i></th>
                <th>Last search</th>
                <?php echo $list;?>
            </table>
            <br />
        </div>
        <?php require 'templates/script_bottom.part.php';?>
    </body>
    <?php require 'templates/footer.part.php';?>
</html>