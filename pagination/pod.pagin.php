<?php

require_once('includes/check.inc.php');
require_once('functions/facebook_time_ago.php');

$rows = R::count('pod');
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

$pods = R::find('pod', 'ORDER BY id DESC '.$limit);

if ($last == 1) {
    $text_line2 = "";
} else {
    $text_line2 = "Page <b>{$page_num}</b> of <b>{$last}</b>";
}

$pagination_controls = "";

// Pagination controls
if ($last != 1) {
    if ($page_num > 1) {
        $previous = $page_num - 1;
        $pagination_controls .= '<a href='.$_SERVER['PHP_SELF'].'?page='.$previous.'>
                                    <i class="fas fa-angle-left"></i>
                                </a>';
        // Links on the left of the target page number
        for ($i = $page_num-4; $i < $page_num; $i++) {
            if ($i > 0) {
                $pagination_controls .= '<a href='.$_SERVER['PHP_SELF'].'?page='.$i.'>'.$i.'</a>';
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
        $pagination_controls .= '<a href='.$_SERVER['PHP_SELF'].'?page='.$next.'>
                                    <i class="fas fa-angle-right"></i>
                                </a>';
    }
}

$list = '';

if (isset($_COOKIE['rejected_pod'])) {
    $if_has_cookie = rand();
} else {
    $if_has_cookie = '';
}

foreach ($pods as $pod) {
    // For all users
    if ($pod->approved == 2) {
        $list .= '  <div class="stories">
                        <hr>
                        <a href="podcast_page.php?id='.$pod->id.'">
                            <img src="media/img/imgs/pod'.$pod->id.'.jpg?'.$if_has_cookie.'" class="stories-img" alt="Podcast '.$pod->id.'" title="Open '.$pod->subject.'">
                        </a>

                        <h4 class="headline1">'.$pod->subject.'</h4>
                        <h3 class="headline2">Podcast. Episod '.$pod->id.'</h3>

                        <p>'.nl2br($pod->intro).'.. 
                            <a href="podcast_page.php?id='.$pod->id.'">
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </p>

                        <div class="date" style="text-align:center;">
                            <h4><i><i class="fas fa-user"></i></i> '.$pod->author.'</h4>
                            <span>'.facebook_time_ago($pod->date).'</span>
                        </div>
                    </div>';
    }

    // For admins and writers only
    if ($pod->approved != 2 && ($admin_ok === true || $host_ok === true)) {
        $list .= '  <div class="stories" style="opacity: 0.8;">
                        <hr>
                        <a href="podcast_page.php?id='.$pod->id.'">
                            <img src="media/img/imgs/pod'.$pod->id.'.jpg?'.$if_has_cookie.'" class="stories-img" alt="Podcast '.$pod->id.'" title="Open '.$pod->subject.'">
                            <div class="for-admins">Votes: '.$pod->approved.'/2</div>
                        </a>

                        <h4 class="headline1">'.$pod->subject.'</h4>
                        <h3 class="headline2">Podcast. Episod '.$pod->id.'</h3>

                        <p>'.nl2br($pod->intro).'.. 
                            <a href="podcast_page.php?id='.$pod->id.'">
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </p>

                        <div class="date" style="text-align:center;">
                            <h4><i><i class="fas fa-user"></i></i> '.$pod->author.'</h4>
                            <span>'.facebook_time_ago($pod->date).'</span>
                        </div>
                    </div>';
    }
}