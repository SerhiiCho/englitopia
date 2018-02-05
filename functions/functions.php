<?php

//Escape func
function escapeChars($value) {
    return htmlspecialchars($value,ENT_QUOTES,'UTF-8');
}

require 'facebook_time_ago.php';

?>