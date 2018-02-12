<?php
require_once('../includes/check.inc.php');
require_once('../functions/facebook_time_ago.php');

$results_count = $_POST['post_results_count'];

$rows_p = R::count('favoritepod', 'id_user = ?',
    [$user_id]
);

$results_on_page = $results_count;
$show_pod_more_results = $rows_p - $results_on_page;
$list_p = '';
$i = 1;

$find_all_favs = R::find('favoritepod', 'id_user = ?',
    [$user_id]
);

if ($find_all_favs) {

    foreach ((array) $find_all_favs as $all) {
        $i++;
        $favs_p = R::load("pod", $all->id_pod);

        $img = '<img src="media/img/imgs/pod'.$favs_p->id.'.jpg" alt="'.$favs_p->subject.'" class="favorites-pic">';

        $list_p .= '<a href="podcast_page.php?id='.$favs_p->id.'" title="'.$favs_p->subject.'">'.$img.'</a>
                    <a href="podcast_page.php?id='.$favs_p->id.'" title="'.$favs_p->subject.'">
                        <div class="conversations">

                            <h4 id="conversations-date">
                                Posted '.facebook_time_ago($favs_p->date).'
                            </h4>

                            <p id="conversations-from">
                                <b>'.$favs_p->id.'. '.$favs_p->subject.'</b>
                            </p>

                            <p class="conversations-content" style="margin:.18rem 2.06rem 0 4.37rem;">
                                '.substr($favs_p->intro,0,40).'...
                            </p>
                        </div>
                    </a>';

        // Breaking loop
        if ($i > $results_on_page || $i > $rows_p) {
            break;
        }
    }

}

if ($rows_p < 1) {
    $list_p = ' <div class="intro">
                    <p>You don\'t have any favorite podcast</p>
                </div>';
}

echo $list_p;

if ($rows_p > $results_on_page) {
    echo '  <div class="intro">
                <p>There '.$show_pod_more_results.' are more results</p>
            </div>';
}