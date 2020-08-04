<?php

require_once('includes/check.inc.php');
require_once('functions/facebook_time_ago.php');

$rows = R::count('info');
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

$info = R::find('info', 'ORDER BY id DESC '.$limit);

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

foreach ($info as $i) {

    $list .= "  <a href='info_page.php?id={$i->id}' title='Open {$i->subject}'>
                    <div class='button'>
                        <h4>{$i->subject}</h4>
                    </div>
                </a>";
}