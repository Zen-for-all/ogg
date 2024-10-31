<?php
session_start();
require '../connect.php';

// get $_POST params
$id = $_POST['id'];
$date = date("d.m.y", strtotime($_POST['date']));
$time = $_POST['time'];
$duration = $_POST['duration'];
$location = $_POST['location'];
$quality = $_POST['quality'];
$interest = $_POST['interest'];
$method = $_POST['method'];
$text = trim(htmlentities($_POST['text']));
$notice = trim(htmlentities($_POST['notice']));
$public_text = trim(htmlentities($_POST['public_text']));
if (isset($_POST['publish']) && $_POST['publish'] === 'on') {
  $publish = 1;
} else {
  $publish = 0;
}

$user = $_SESSION['userid'];

// update ld
$checkExistingRecord = mysqli_query($connect, "SELECT * FROM `ld` WHERE `id` = '$id'");

if (mysqli_num_rows($checkExistingRecord) > 0) {
  $updateRecord = mysqli_query($connect, "UPDATE `ld` SET
        `date` = '$date',
        `time` = '$time',
        `duration` = '$duration',
        `location` = '$location',
        `quality` = '$quality',
        `interest` = '$interest',
        `method` = '$method',
        `text` = '$text',
        `notice` = '$notice',
        `public_text` = '$public_text',
        `publish` = '$publish',
        `user` = '$user'
        WHERE `id` = '$id'");
}

header("location:/?page=ld&id=" . $id);