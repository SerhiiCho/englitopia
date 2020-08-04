<?php

require_once('includes/check.inc.php');

// Count
$rows = R::count("members", "id != ?", [1]);

$page_rows = 50;
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

$text_line1 = "<b>{$rows}</b> members";

if ($last == 1) {
    $text_line2 = "";
} else {
    $text_line2 = "Page <b>{$page_num}</b> of <b>{$last}</b>";
}

$pagination_controls = '';

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

$members = R::find('members', 'WHERE id != 1 ORDER BY reports DESC '.$limit);

if ($members) {
    foreach ((array) $members as $member) {
        $user_id = $member->id;
        $username_short = substr($member->username,0,10);
        $username = $member->username;
        $reports = $member->reports;

        $blockee = R::count("blockedusers", "blockee = ?",
            [$username]
        );

        $list .= "  <tr>
                        <td>{$user_id}</td>
                        <td>
                            <a href='admin_profile.php?member=/{$username}' class='link-to-user' title='Open {$username} profile'>
                                {$username_short}
                            </a>
                        </td>
                        <td>{$reports}</td>
                        <td>{$blockee}</td>
                    </tr>";
    }
}