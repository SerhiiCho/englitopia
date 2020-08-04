<?php

require_once("../includes/check.inc.php");
check_member();

if (isset($_POST['from']) && isset($_POST['to'])) {
    $message = '';
    $report_date = date("Y-m-d");
    $report_time = date("H:i:s");
	$from = preg_replace('#[^a-z0-9]#i', '', $_POST['from']);
    $to = preg_replace('#[^a-z0-9]#i', '', $_POST['to']);
    $message = $_POST['message'];
    $type = $_POST['type'];

    // If exist
	if (R::count("members", "username = ? AND active = ?", array($to, 1)) < 1) {
        header("Location: ../report.php?message=/does_not_exist");
        exit();
	}

    if (empty($type)) {
        header("Location: ../report.php?message=/empty");
        exit();
    }

    // If already sent
    $if_sent = R::count("reports", "from_user = ?
                                AND to_user = ?
                                AND report_date = ?",
                                array($from, $to, $report_date));

    if ($if_sent > 0) {
        header("Location: ../report.php?message=/you_alredy_reported_today");
        exit();
    }

    // Insert report
    $new_report = R::dispense('reports');

    $new_report->from_user = $from;
    $new_report->to_user = $to;
    $new_report->report_date = $report_date;
    $new_report->report_time = $report_time;
    $new_report->type = $type;
    $new_report->message = $message;

    R::store($new_report);

    // Update member's table
    R::getAll("UPDATE members SET reports = reports + 1
                WHERE username = '$to' LIMIT 1");

    header("Location: ../report.php?message=/success");
} else {
    header('location: redirect.php?message=/error');
}