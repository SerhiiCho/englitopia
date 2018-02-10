<?php

require_once('includes/check.inc.php');

$status = $_SERVER['REDIRECT_STATUS'];

$codes = [
       403 => ['403 Forbidden', 'Oops! The server has refused to fulfill your request.'],
       404 => ['404 Not Found', 'Oops! The page was not found on Englitopia server.'],
       405 => ['405 Method Not Allowed', 'Oops! The method specified in the Request-Line is not allowed for the specified resource.'],
       408 => ['408 Request Timeout', 'Oops! Your browser failed to send a request in the time allowed by the server.'],
       500 => ['500 Internal Server Error', 'Oops! The request was unsuccessful due to an unexpected condition encountered by the server.'],
       502 => ['502 Bad Gateway', 'Oops! The server received an invalid response from the upstream server while trying to fulfill the request.'],
       504 => ['504 Gateway Timeout', 'Oops! The upstream server failed to send a request in the time allowed by the server.'],
];

$title_error = $codes[$status][0];
$message_error = $codes[$status][1];

if ($title_error == false || strlen($status) != 3) {
        $title_error = 'Unrecognized error code';
        $message_error = 'Please supply a valid status code.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('templates/head.part.php');?>
    <title><?php echo $title_error;?></title>
</head>
    <?php require_once('templates/nav.part.php');?>
<body>
    <div class="wrapper-big">
        <img src="media/img/dragon_error.png?v=1" alt="Englitopia" title="Englitopia">
        <h2><? echo $title_error;?></h2><br />
        <h3><? echo $message_error;?></h3>
        <hr class="hr-mobile">
    </div>
    <?php require_once('templates/script_bottom.part.php');?>
</body>
</html>