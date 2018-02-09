<?php

require_once('includes/check.inc.php');

// Count
$rows = R::count("postoffice");

$page_rows = 30;
$last = ceil($rows/$page_rows);

if ($last < 1) {
    $last = 1;
}

$page_num = 1;

if (isset($_GET['page'])) {
    $page_num = preg_replace('#[^0-9]#','', $_GET['page']);
}

if ($page_num < 1) { 
    $page_num = 1; 
} elseif ($page_num > $last) { 
    $page_num = $last; 
}

$limit = 'LIMIT ' .($page_num - 1) * $page_rows .',' .$page_rows;

$text_line1 = "<b>{$rows}</b> messages";

if ($last == 1) {
    $text_line2 = "";
} else {
    $text_line2 = "Page <b>{$page_num}</b> of <b>{$last}</b>";
}

$pagination_controls = '';

if ($last != 1) {
    if ($page_num > 1) {
        $previous = $page_num - 1;
        $pagination_controls .= "<a href='{$_SERVER['PHP_SELF']}?page={$previous}'><i class='fa fa-arrow-left' aria-hidden='true'></i></a>";

        for ($i = $page_num-4; $i < $page_num; $i++) {
            if ($i > 0) {
                $pagination_controls .= "<a href='{$_SERVER['PHP_SELF']}?page={$i}'>{$i}</a>";
            }
        }
    }

    $pagination_controls .= "<h4>{$page_num}</h4>";

    for ($i = $page_num+1; $i <= $last; $i++) {
        $pagination_controls .= "<a href='{$_SERVER['PHP_SELF']}?page={$i}'>{$i}</a>";
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
$icon = '';
$color = '';

$messages = R::find('postoffice', 'ORDER BY id DESC '.$limit);

if ($messages) {
    foreach ((array) $messages as $msg) {

        $msg->date = date("M j, Y, g:i a", strtotime($msg->date));;

        if ($msg->type === 'attention') {
            $icon = 'fas fa-exclamation-circle';
            $color = 'firebrick';
        } else {
            $icon = 'far fa-envelope';
            $color = '#444';
        }

        $list .= '  <div class="post-office">
                        <i class="'.$icon.'" style="color:'.$color.';"></i>
                        <div>
                            <span>'.$msg->message.'</p>
                            <p class="date">'.$msg->date.'</p>
                        </div>
                    </div>';
    }
}

R::getAll("UPDATE membersdata
            SET admin_note_check = now()
            WHERE user_id = '$user_id'
            LIMIT 1");