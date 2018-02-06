<?php

require 'includes/check.inc.php';
require 'functions/facebook_time_ago.php';
check_member();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'templates/head.part.php';?>
        <title>Favorites</title>

        <!-- Emphasize menu button -->
        <style>#profile-menu-line-favorites{border-bottom:solid .125rem gray;}</style>
    </head>
        <?php require 'templates/nav.part.php';?>
    <body>
        <div class="wrapper">
            <?php require 'templates/profile_menu.part.php';?>

            <!-- Intro -->
            <div class="intro">
                <h1>Favorites</h1>
            </div>
            <div class="header2">

                <?php
                    $message = isset($_REQUEST['message']) ? $_REQUEST['message']:null;
                    switch($message) {
                        case '/deleted_story':
                            echo '<h4 class="success">Favorite story has been deleted from the list.</h4>'; 
                            break;
                        case '/deleted_pod':
                            echo '<h4 class="success">Favorite podcast has been deleted from the list.</h4>'; 
                            break;
                        case '/error_pod':
                            echo '<h4 class="error">Can\'t delete this podcast, unknown error occurred.</h4>'; 
                            break;
                        case '/error_story':
                            echo '<h4 class="error">Can\'t delete this story, unknown error occurred.</h4>'; 
                            break;
                    }
            	?>

                <div class="tab">
                    <button class="tablinks" style="width:49%;" onclick="openTab(event,'tab1')" id="default_open">Stories</button>
                    <button class="tablinks" id="btn_pods" style="width:49%;" onclick="openTab(event,'tab2')">Podcast</button>
                </div>

                <script>
                    // Button show more stories
                    $(document).ready(function() {
                        var results_count = 20;
                        $("#button-load-stories").click(function() {
                            results_count = results_count + 20;
                            $("#load_more_stories").load("loads/load_favorite_stories.php", {
                                post_results_count: results_count
                            });
                        });
                    });

                    // Button show more pods
                    $(document).ready(function() {
                        var results_count = 20;
                        $("#button-load-pods").click(function() {
                            results_count = results_count + 20;
                            $("#load_more_pods").load("loads/load_favorite_pods.php", {
                                post_results_count: results_count
                            });
                        });
                    });
                </script>

                <!-- STORIES TAB -->
                <div id="tab1" class="tabcontent">
                    <div id="load_more_stories">
                        <?php require 'templates/favorite_stories.part.php';?>
                    </div>
                    <?php
                    	if ($rows_st > $results_on_page) {
                    		echo '<button class="close_notif center" id="button-load-stories">Show more</button>';
                    	}
                    ?>
                </div>

                <!-- PODCASTS TAB -->
                <div id="tab2" class="tabcontent">
                    <div id="load_more_pods">
                        <?php require 'templates/favorite_pods.part.php';?>
                    </div>

                    <?php
                        if ($rows_p > $results_on_page) {
                            echo '<button class="close_notif center" id="button-load-pods">Show more</button>';
                        }
                    ?>

                </div>
            </div>
        </div>
        <?php require 'templates/script_bottom.part.php';?>

        <script>

            /*After deleting favorites, favorite.inc.php will bring us back to
            this page and add 'message=/deleted_pod'' to the url. This if
            statment clicks button 'btn_pods'*/
            var podsBtn = document.getElementById("btn_pods"),
                openDefault = document.getElementById("default_open"),
                openPod = document.getElementById("podcasts_open");

            if (document.URL.indexOf("message=/deleted_pod") >= 0|| document.URL.indexOf("/error_pod") >= 0) { 
                podsBtn.click();
            } else {
                openDefault.click();
            }
            openPod.click();

            function openTab(evt, name) {
                var i, tabcontent, tablinks,
                    tabcontent = document.getElementsByClassName("tabcontent"),
                    tablinks = document.getElementsByClassName("tablinks"),
                    name = document.getElementById(name);
                
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }

                name.style.display = "block";
                evt.currentTarget.className += " active";
            }
        </script>

    </body>
    <?php require 'templates/footer.part.php';?>
</html>