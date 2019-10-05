<?php

session_start();
include "connection.php";
include "functions.php";

$loginid = end($_SESSION[SESS_MEMBER_ID]);
if (isset($_POST['queid']) && $_POST['queid'] != '') {
    $wid = $_POST['queid'];
    $to_user_id = $_POST['touser'];
    $action = "que_liked";

    $cheklike_que = mysql_query("SELECT * from freelancer_mmv_que_ans_likes where questions_id='$wid' AND liked_by=$loginid");
    $cheklike = mysql_num_rows($cheklike_que);

    if ($cheklike <= 0) {
        $imgquery = mysql_query("INSERT INTO freelancer_mmv_que_ans_likes (questions_id, liked_by, created) VALUES ('" . $wid . "','" . $loginid . "',NOW())");
        add_member_notification($loginid, $to_user_id, $action, 0, $wid);
    } else {
        $imgquery = mysql_query("DELETE FROM freelancer_mmv_que_ans_likes WHERE liked_by='" . $loginid . "' AND questions_id='" . $wid . "'");
        add_member_notification($loginid, $to_user_id, $action, 1, $wid);
    }

    $like_que = mysql_query("SELECT * from freelancer_mmv_que_ans_likes where questions_id='$wid'");
    $count = mysql_num_rows($like_que);

    if ($imgquery) {
        echo $count;
    }
} else if (isset($_POST['ansid']) && $_POST['ansid'] != '') {
    $wid = $_POST['ansid'];
    $to_user_id = $_POST['touser'];
    $action = "ans_liked";

    $cheklike_que = mysql_query("SELECT * from freelancer_mmv_que_ans_likes where answers_id='$wid' AND liked_by=$loginid");
    $cheklike = mysql_num_rows($cheklike_que);

    if ($cheklike <= 0) {
        $imgquery = mysql_query("INSERT INTO freelancer_mmv_que_ans_likes (answers_id, liked_by, created) VALUES ('" . $wid . "','" . $loginid . "',NOW())");
        add_member_notification($loginid, $to_user_id, $action, 0, $wid);
    } else {
        $imgquery = mysql_query("DELETE FROM freelancer_mmv_que_ans_likes WHERE liked_by='" . $loginid . "' AND answers_id='" . $wid . "'");
        add_member_notification($loginid, $to_user_id, $action, 1, $wid);
    }

    $like_que = mysql_query("SELECT * from freelancer_mmv_que_ans_likes where answers_id='$wid'");
    $count = mysql_num_rows($like_que);

    if ($imgquery) {
        echo $count;
    }
}
?>