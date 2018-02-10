<?php require 'pagination/index.pagin.php';?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Englitopia</title>
        <?php require_once('templates/head.part.php');?>        
    </head>
        <?php require_once('templates/nav.part.php');?>
    <body>
    <div class="wrapper">

        <!-- Banner/Slider. There are 6 pics, 3 for large screen, 3 for mobile screen -->
        <div class="main-banner">
            <div class="imgbanbtn imgbanbtn-prev"></div>

            <picture class="bannerImg">
                <source media="(min-width: 28.75rem)" srcset="media/img/banner1.jpg">
                <img src="media/img/banner1_min.jpg" alt="banner">
            </picture>
            <picture class="bannerImg">
                <source media="(min-width: 28.75rem)" srcset="media/img/banner2.jpg">
                <img src="media/img/banner2_min.jpg" alt="banner">
            </picture>
            <picture class="bannerImg">
                <source media="(min-width: 28.75rem)" srcset="media/img/banner3.jpg">
                <img src="media/img/banner3_min.jpg" alt="banner">
            </picture>

            <div class="imgbanbtn imgbanbtn-next"></div>
        </div>

        <div class="news"><?php echo $list_pod;?></div>
        <div class="news"><?php echo $list_story;?></div>
        <br />
    </div>

        <!-- Alert for Opera Mini -->
        <script type="text/javascript">
            function operaMini() {
                var isMobile = {
                    Opera: function() {
                        return navigator.userAgent.match(/Opera Mini/i);
                    },
                };

                if (isMobile.Opera()) {
                    alert('If you are using Opera Mini please disable [Data Savings Mode] to have a pleasant browsing experience :) You can make it by going to [Settings] > [Data Savings] and turn off [Extreme Mode] or you can also change it to [High] if it has that option.');
                }
            }
            window.onload = operaMini;
        </script>
        <script type="text/javascript" src="js/banner.js"></script>
        <?php require_once('templates/script_bottom.part.php');?>
    </body>

    <?php
        require_once('templates/footer.part.php');

        // Page counter
        if (!isset($_SESSION['has_visited'])) {
			$_SESSION['has_visited']="yes";

            // If row has been already created
            if (R::count('visits', 'date = ?', [date("d.m.y")]) > 0) {
                $views = R::findOne('visits', 'date = ?', [date("d.m.y")]);

                $views->value = $views->value + 1;

                R::store($views);
            } else {
                $views = R::dispense('visits');

                $views->date = date("d.m.y");
                $views->month = date("M");
                $views->week = date("D");
                $views->year = date("Y");
                $views->value = 1;

                R::store($views);
            }
		}
    ?>
</html>