<?php
require_once('../includes/check.inc.php');
require_once('../functions/facebook_time_ago.php');

$results_count = $_POST['post_results_count'];

$rows_st = R::count('favoritestory', 'id_user = ?',
    [$user_id]
);

$results_on_page = $results_count;
$show_st_more_results = $rows_st - $results_on_page;
$list_st = '';
$i = 1;

$find_all_favs = R::find('favoritestory', 'id_user = ?',
    [$user_id]
);

if ($find_all_favs) {

    foreach ((array) $find_all_favs as $all) {
        $i++;
        $favs = R::load("stories", $all->id_story);

        $img = '<img src="media/img/imgs/story'.$favs->id.'.jpg"
                    alt="'.$favs->subject.'"
                    class="favorites-pic">';

        $list_st .= '<a href="story_page.php?id='.$favs->id.'" 
                        title="'.$favs->subject.'">'.$img.'
                    </a>
                        <a href="story_page.php?id='.$favs->id.'" 
                            title="'.$favs->subject.'">
                            <div class="conversations">

                                <h4 id="conversations-date">
                                    Posted '.facebook_time_ago($favs->date).'
                                </h4>

                                <p id="conversations-from">
                                    <b>'.$favs->id.'. '.$favs->subject.'</b>
                                </p>

                                <p class="conversations-content" style="margin:.18rem 2.06rem 0 4.37rem;">
                                    '.substr($favs->intro,0,40).'...
                                </p>
                                </div>
                            </div>
                        </a>';


        // Breaking loop
        if ($i > $results_on_page || $i > $rows_st) {
            break;
        }
    }
}
if ($rows_st < 1) {
    $list_st = '<div class="intro">
                    <p>You don\'t have any favorite stories</p>
                </div>';
}

echo $list_st;

if ($rows_st > $results_on_page) {
    echo '  <div class="intro">
                <p>There are '.$show_st_more_results.' more results</p>
            </div>';
}