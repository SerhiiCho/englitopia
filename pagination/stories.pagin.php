<?php

require 'includes/check.inc.php';
require 'functions/facebook_time_ago.php';

$rows = R::count('stories');
$page_rows = 16;
$last = ceil($rows/$page_rows);
$page_num = 1;

if ($last < 1) {
    $last = 1;
}

if (isset($_GET['page'])) {
    $page_num = preg_replace('#[^0-9]#','', $_GET['page']);
}

if ($page_num < 1) { 
    $page_num = 1; 
} elseif ($page_num > $last) { 
    $page_num = $last; 
}

$limit = 'LIMIT ' .($page_num - 1) * $page_rows .',' .$page_rows;

$stories = R::find('stories', 'ORDER BY id DESC '.$limit);

if ($last == 1) {
    $text_line2 = "";
} else {
    $text_line2 = "Page <b>{$page_num}</b> of <b>{$last}</b>";
}

$pagination_controls = "";

if ($last != 1) {
    if ($page_num > 1) {
        $previous = $page_num - 1;
        $pagination_controls .= "<a href='{$_SERVER['PHP_SELF']}?page={$previous}'><i class='fa fa-arrow-left' aria-hidden='true'></i></a>";

        // Number on the left
        for ($i = $page_num-4; $i < $page_num; $i++) {
            if ($i > 0) {
                $pagination_controls .= "<a href='{$_SERVER['PHP_SELF']}?page={$i}'>{$i}</a>";
            }
        }
    }

    $pagination_controls .= '<h4>'.$page_num.'</h4>';

    for ($i = $page_num+1; $i <= $last; $i++) {
        $pagination_controls .= '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.'</a>';

        if ($i >= $page_num+4) {
            break;
        }
    }

    if ($page_num != $last) {
        $next = $page_num + 1;
        $pagination_controls .= "<a href='{$_SERVER['PHP_SELF']}?page={$next}'><i class='fa fa-arrow-right' aria-hidden='true'></i></a>";
    }
}

$list = '';

if (isset($_COOKIE['rejected_story'])) {
    $if_has_cookie = rand();
} else {
    $if_has_cookie = '';
}

foreach ($stories as $story) {
    // For all users
    if ($story->approved == 2) {
        $list .= '  <div class="stories">
                        <hr>
                        <a href="story_page.php?id='.$story->id.'">
                            <img src="media/img/imgs/story'.$story->id.'.jpg?'.$if_has_cookie.'" class="stories-img" alt="Story '.$story->id.'" title="Open '.$story->subject.'">
                        </a>

                        <h4 class="headline1">'.$story->subject.'</h4>
                        <h3 class="headline2">Story '.$story->id.'</h3>

                        <p>'.nl2br($story->intro).'.. 
                            <a href="story_page.php?id='.$story->id.'">
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </p>

                        <div class="date">
                            <h4><i><i class="fas fa-user"></i></i> '.$story->author.'</h4>
                            <span>'.facebook_time_ago($story->date).'</span>
                        </div>
                    </div>';
    }

    // For admins and writers only
    if ($story->approved != 2 && ($admin_ok === true || $writer_ok === true)) {
        $list .= '  <div class="stories">
                        <hr>
                        <a href="story_page.php?id='.$story->id.'">
                            <img src="media/img/imgs/story'.$story->id.'.jpg?'.$if_has_cookie.'" class="stories-img" alt="Story '.$story->id.'" title="Open '.$story->subject.'">
                        </a>

                        <h4 class="headline1">'.$story->subject.'</h4>
                        <h3 class="headline2">Story '.$story->id.'</h3>

                        <p>'.nl2br($story->intro).'.. 
                            <a href="story_page.php?id='.$story->id.'">
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </p>

                        <div class="date">
                            <h4><i><i class="fas fa-user"></i></i> '.$story->author.'</h4>
                            <span>'.facebook_time_ago($story->date).'</span>
                        </div>
                    </div>';
    }
    
}