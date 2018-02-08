<?php

$fav_p = R::findOne('membersdata', 'user_id = ?', array($user_id));

// Transforming strings into arrays
$pieces_array_p = explode(", ", $fav_p->favorite_pod);

// Counting array's elements
$rows_p = count($pieces_array_p) - 1;

$results_on_page = 20;
$show_pod_more_results = $rows_p - $results_on_page;
$list_p = '';
$i = 1;

// Favorite podcasts
if ($rows_p > 0) {

    /*Foreach for every element, $i helps us know how many results we have
    if more than 50 we'll break the loop'*/
    foreach ((array) $pieces_array_p as $piece) {
        $i++;
        $favs_p = R::load("pod", $piece);

        $img = '<img src="media/img/imgs/pod'.$favs_p->id.'.jpg" alt="'.$favs_p->subject.'" class="favorites-pic">';

        $list_p .= '<a href="podcast_page.php?id='.$favs_p->id.'" title="'.$favs_p->subject.'">'.$img.'</a>
                    <a href="podcast_page.php?id='.$favs_p->id.'" title="'.$favs_p->subject.'">
                        <div class="conversations">

                            <h4 id="conversations_date">
                                Posted '.facebook_time_ago($favs_p->date).'
                            </h4>

                            <p id="conversations_from">
                                <b>'.$favs_p->id.'. '.$favs_p->subject.'</b>
                            </p>

                            <p class="conversations_content" style="margin:.18rem 2.06rem 0 4.37rem;">
                                '.substr($favs_p->intro,0,40).'...
                            </p>

                            <div class="delete_conversations">
                                <form action="includes/favorite.inc.php" method="POST">
                                    <input type="hidden" name="_token" value="'.$_SESSION['_token'].'">
                                    <input type="hidden" name="came_from" value="favorites_pod">
                                    <input type="hidden" name="p_id" value="'.$favs_p->id.'">
                                    <input type="checkbox" style="display:none;" name="check_box_pod" id="check_box2" onchange="this.form.submit()" value="0">

                                    <label for="check_box2">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </label>
                                </form>
                            </div>
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
?>