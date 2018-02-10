<?php

require_once('includes/check.inc.php');
require_once('functions/functions.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Search</title>
        <?php require_once('templates/head.part.php');?>
    </head>
        <?php require_once('templates/nav.part.php');?>
    <body>
        <div class="wrapper">

            <!-- Search form -->
            <div class="header2">
                <form method="POST" class="search-form">
                    <input type="search" name="search" placeholder="Write a keyword" required maxlength="20">
                    <button type="submit" name="submit-search" class="hid"></button>
                </form>

                <?php
                    if (isset($_POST["submit-search"])) {

                        $search = strtolower(preg_replace('#[^a-zA-Z- ]#i','',$_POST['search']));

                        // Save search words to statistic
                        if (R::count('searchstat', 'words = ?', [$search]) > 0) {

                            // If there are no such word in database stats, add one
                            $search_load = R::getAll("UPDATE searchstat
                                                    SET times = `times` + 1,
                                                    last_date = now()
                                                    WHERE words = '$search'");
                        } else {
                            // Create table
                            $serch_create = R::dispense('searchstat');

                            $serch_create->words = $search;
                            $serch_create->times = 1;
                            $serch_create->last_date = date("Y-m-d H:i:s");

                            R::store($serch_create);
                        }

                        if ($member_ok == true) {
                            $search_load = R::getAll("UPDATE membersdata
                                                    SET searching = concat(searching, '$search, ')
                                                    WHERE user_id = '$user_id'");
                        }
                    }
                ?>

                <script>
                    // Loads more results
                    var search = "<?php echo $search?>";
                    $(document).ready(function() {
                        var search_count = 30;
                        $("#button").click(function() {
                            search_count = search_count + 15;
                            $("#load-search").load("loads/load_search.php", {
                                post_search_new_count: search_count,
                                post_search: search
                            });
                        });
                    });
                </script>

                <!-- In this div will be uploaded load_search.php after pressing button load more -->
                <div id="load-search">
                    <?php
                        if (isset($_POST["submit-search"])) {

                            // Select stories
                            $stories = R::getAll("SELECT * FROM stories
                                                WHERE approved = 2
                                                AND (subject LIKE '%$search%'
                                                OR 'everything' LIKE '%$search%'
                                                OR 'story' LIKE '%$search%'
                                                OR tags LIKE '%$search%')
                                                LIMIT 10");

                            // Select pods
                            $pods = R::getAll("SELECT * FROM pod
                                                WHERE approved = 2
                                                AND (subject LIKE '%$search%'
                                                OR 'everything' LIKE '%$search%'
                                                OR tags LIKE '%$search%')
                                                LIMIT 10");

                            // Select info
                            $info = R::getAll("SELECT * FROM info
                                                WHERE subject LIKE '%$search%'
                                                OR 'everything' LIKE '%$search%'
                                                OR 'info' LIKE '%$search%'
                                                OR tags LIKE '%$search%'
                                                LIMIT 10");

                            // Count results
                            $st_rows = count($stories);
                            $p_rows = count($pods);
                            $i_rows = count($info);
                            $errors = [];

                            // Errors handlers
                            if (empty($search)) {
                                $errors[] = 'Search field is empty';
                            }

                            // If less than 3 or more than 20
                            if (strlen($search) < 3||strlen($search) > 20) {
                                $errors[] = 'Your search must contain at least 3 letters';
                            }

                            // If there are no results
                            if ($st_rows < 1 && $p_rows < 1 && $i_rows < 1) {
                                $errors[] = 'We have nothing for query: <span style="color:brown;">'.$search.'</span>';
                            } else {
                                // Echo how many results we got
                                echo '<div class="intro">
                                <p>';
                                    if ($st_rows==1) { echo $st_rows.' story '; }
                                    if ($st_rows>1) { echo $st_rows.' stories '; }
                                    if ($p_rows==1) { echo $p_rows.' podcast '; }
                                    if ($p_rows>1) { echo $p_rows.' podcasts '; }
                                    if ($i_rows>0) { echo $i_rows.' info'; }
                                    echo ' for query: <b>'.escapeChars($search).'</b>
                                </p>
                            </div>';
                            }

                            if (!empty($errors)) {
                                echo '<h5 class="original">'.array_shift($errors).'</div>';
                            } else {

                                // Show stories
                                foreach ((array) $stories as $st) {
                                    echo '  <div>
                                                <a href="story_page.php?id='.$st['id'].'" title="'.$st['subject'].'">
                                                    <img src="media/img/imgs/story'.$st['id'].'.jpg" class="favorites-pic" alt="'.$st['subject'].'">
                                                </a>
                                                <div>
                                                    <div class="conversations">
                                                        <h4 id="conversations_date">Posted '.facebook_time_ago($st['date']).'</h4>
                                                        <p id="conversations_from"><b>Story '.$st['id'].'. '.$st['subject'].'</b></p>
                                                        <p class="conversations_content">'.substr($st['intro'],0,40).'...</p>
                                                    </div>
                                                </div>
                                            </div>';
                                }

                                // Show pods
                                foreach ((array) $pods as $p) {
                                    echo '  <div>
                                                <a href="podcast_page.php?id='.$p['id'].'" title="'.$p['subject'].'">
                                                    <img src="media/img/imgs/pod'.$p['id'].'.jpg" class="favorites-pic" alt="'.$p['subject'].'">
                                                </a>
                                                <div>
                                                    <div class="conversations">
                                                        <h4 id="conversations_date">Posted '.facebook_time_ago($p['date']).'</h4>
                                                        <p id="conversations_from"><b>Podcast '.$p['id'].'. '.$p['subject'].'</b></p>
                                                        <p class="conversations_content">'.substr($p['intro'],0,40).'...</p>
                                                    </div>
                                                </div>
                                            </div>';
                                }

                                // Show info
                                foreach ((array) $info as $in) {
                                    echo '  <div>
                                                <a href="info_page.php?id='.$in['id'].'" title="'.$in['subject'].'">
                                                    <img src="media/img/info_pic.jpg" class="favorites-pic" alt="'.$in['subject'].'">
                                                </a>
                                                <div>
                                                    <div class="conversations">
                                                        <h4 id="conversations_date">Posted '.facebook_time_ago($in['date']).'</h4>
                                                        <p id="conversations_from"><b>'.$in['subject'].'</b></p>
                                                        <p class="conversations_content">Information</p>
                                                    </div>
                                                </div>
                                            </div>';
                                }
                            }
                        } else {
                            echo '<h5 class="original">Use search box to find a story, poscast\'s episode or information about our community by keywords or name.</h5>';
                        }
                    ?>
                </div>

                <?php
                    // Button "Show more"
	                if (isset($_POST["submit-search"])) {
	                    $all_results = $st_rows + $p_rows + $i_rows;
	                    if ($all_results >= 30) {
	                        if (strlen($search) >= 3) {
	                            echo '<button class="close_notif center" id="button">Show more</button>';
	                        }
	                    }
	                }
	            ?>
            </div>
        </div>
        <?php require_once('templates/script_bottom.part.php');?>
    </body>
    <?php require_once('templates/footer.part.php');?>
</html>