<?php

// result_to_array
function result_to_array ($result) {
    $array = array();
    while (($row = $result->fetch_assoc()) != false)
    $array[] = $row;
    return $array;
}

// Chat page
function get_chat($id) {
    global $mysqli;
    connect_db();
    $result = $mysqli->query("SELECT * FROM messages WHERE id_chat= $id");
    close_db();
    return $result->fetch_assoc();
}

//Escape func
function e($value) {
    return htmlspecialchars($value,ENT_QUOTES,'UTF-8');
}

require 'facebook_time_ago.php';

?>