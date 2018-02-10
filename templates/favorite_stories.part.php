<?php

$fav_st = R::findOne('membersdata', 'user_id = ?',
    [$user_id]
);

// Transforming strings into arrays
$pieces_array_st = explode(", ", $fav_st->favorite_story);

// Counting array's elements
$rows_st = count($pieces_array_st) - 1;

$results_on_page = 20;
$show_st_more_results = $rows_st - $results_on_page;
$list_st = '';
$i = 1;

// Favorite stories
if ($rows_st > 0) {

    /* Foreach for every element, $i helps us know how many results we have
    if more than 50 we'll break the loop */
    foreach((array) $pieces_array_st as $piece) {
        $i++;
        $favs = R::load("stories", $piece);

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

                                <div class="delete_conversations">
                                    <form action="includes/favorite.inc.php" method="POST">
                                        <input type="hidden" name="_token" value="'.$_SESSION['_token'].'">
                                        <input type="hidden" name="came_from" value="favorites_story">
                                        <input type="hidden" name="st_id" value="'.$favs->id.'">
                                        <input type="checkbox" style="display:none;" name="check_box_st" id="check_box1" onchange="this.form.submit()" value="0">

                                        <label for="check_box1">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </label>
                                    </form>
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