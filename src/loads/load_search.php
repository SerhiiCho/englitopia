<?php
require_once('../includes/check.inc.php');
require_once('../functions/functions.php');

$search_new_count = preg_replace('#[^0-9%]#i','',$_POST['post_search_new_count']);
$search = strtolower(preg_replace('#[^a-zA-Z- ]#i','',$_POST['post_search']));

// Select stories
$stories = R::getAll("SELECT * FROM stories
                    WHERE approved = 2
                    AND (subject LIKE '%$search%'
                    OR 'everything' LIKE '%$search%'
                    OR 'story' LIKE '%$search%'
                    OR tags LIKE '%$search%')
                    LIMIT $search_new_count");

// Select pods
$pods =  R::getAll("SELECT * FROM pod
                    WHERE approved = 2
                    AND (subject LIKE '%$search%'
                    OR 'everything' LIKE '%$search%'
                    OR 'pod' LIKE '%$search%'
                    OR tags LIKE '%$search%')
                    LIMIT $search_new_count");

// Select info
$info = R::getAll("SELECT * FROM info
                    WHERE subject LIKE '%$search%'
                    OR 'everything' LIKE '%$search%'
                    OR 'info' LIKE '%$search%'
                    OR tags LIKE '%$search%'
                    LIMIT $search_new_count");

// Count results
$st_rows = count($stories);
$p_rows = count($pods);
$i_rows = count($info);

// If there are no results
if ($st_rows < 1 && $p_rows < 1 && $i_rows < 1) {
    echo '<h5 class="original">We have nothing for query: <span style="color:brown;">'.$search.'</span></h5>';
} else {

    // Echo how many results we got
    echo '  <div class="intro">
                <p>';
                    if ($st_rows==1) { echo $st_rows.' story ';}
                    if ($st_rows>1) { echo $st_rows.' stories ';}
                    if ($p_rows==1) { echo $p_rows.' podcast ';}
                    if ($p_rows>1) { echo $p_rows.' podcasts ';}
                    if ($i_rows>0) { echo $i_rows.' info';}
                    echo ' for query: <b>'.escapeChars($search).'</b>
                </p>
            </div>';


    // Show stories
    foreach ((array) $stories as $st) {
        echo '  <div>
                    <a href="story_page.php?id='.$st['id'].'" title="'.$st['subject'].'">
                        <img src="img/imgs/story'.$st['id'].'.jpg" class="favorites-pic" alt="'.$st['subject'].'">
                    </a>
                    <div>
                        <div class="conversations">
                            <h4 id="conversations_date">Posted '.facebook_time_ago($st['date']).'</h4>
                            <p id="conversations-from"><b>Story '.$st['id'].'. '.$st['subject'].'</b></p>
                            <p class="conversations_content">'.substr($st['intro'],0,40).'...</p>
                        </div>
                    </div>
                </div>';
    }

    // Show pods
    foreach ((array) $pods as $p) {
        echo '  <div>
                    <a href="podcast_page.php?id='.$p['id'].'" title="'.$p['subject'].'">
                        <img src="img/imgs/pod'.$p['id'].'.jpg" class="favorites-pic" alt="'.$p['subject'].'">
                    </a>
                    <div>
                        <div class="conversations">
                            <h4 id="conversations_date">Posted '.facebook_time_ago($p['date']).'</h4>
                            <p id="conversations-from"><b>Podcast '.$p['id'].'. '.$p['subject'].'</b></p>
                            <p class="conversations_conteznt">'.substr($p['intro'],0,40).'...</p>
                        </div>
                    </div>
                </div>';
    }

    // Show info
    foreach ((array) $info as $in) {
        echo '  <div>
                    <a href="info_page.php?id='.$in['id'].'" title="'.$in['subject'].'">
                        <img src="img/info_pic.jpg" class="favorites-pic" alt="'.$in['subject'].'">
                    </a>
                    <div>
                        <div class="conversations">
                            <h4 id="conversations_date">Posted '.facebook_time_ago($in['date']).'</h4>
                            <p id="conversations-from"><b>'.$in['subject'].'</b></p>
                            <p class="conversations_content">Information</p>
                        </div>
                    </div>
                </div>';
    }
}