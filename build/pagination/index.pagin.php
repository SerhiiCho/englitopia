<?php

require_once('includes/check.inc.php');
require_once('functions/facebook_time_ago.php');

$list_story = '';
$list_pod = '';

// Grabbing page
$pod = R::findOne('pod', 'approved = 2 ORDER BY id DESC LIMIT 1');
$story = R::findOne('stories', 'approved = 2 ORDER BY id DESC LIMIT 1');


if ($pod) {
    $list_pod = '  <div class="event">
                        <h2 class="headline1">'.$pod->subject.'</h2>
                        <h2 class="headline2">Podcast. Episode '.$pod->id.'</h2>

                        <p>'.nl2br($pod->intro).'... 
                            <a href="podcast_page.php?id='.$pod->id.'." title="Open '.$pod->subject.' podcast">
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </p>

                        <span class="date">'.facebook_time_ago($pod->date).'</span>

                        <a  class="link" href="podcast_page.php?id='.$pod->id.'">
                            <img src="media/img/imgs/pod'.$pod->id.'.jpg" alt="Podcast '.$pod->id.'" title="Open podcast '.$pod->id.'">
                        </a>
                    </div>';
}

if ($story) {
    $list_story = '<div class="event">
                        <h2 class="headline1">'.$story->subject.'</h2>
                        <h2 class="headline2">Story '.$story->id.'</h2>

                        <p>'.nl2br($story->intro).'... 
                            <a href="story_page.php?id='.$story->id.'" title="Open '.$story->subject.' story">
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </p>

                        <span class="date">'.facebook_time_ago($story->date).'</span>

                        <a  class="link" href="story_page.php?id='.$story->id.'">
                            <img src="media/img/imgs/story'.$story->id.'.jpg" alt="Story '.$story->id.'" title="Open story '.$story->id.'">
                        </a>
                    </div>';
}