<?php
session_start();
require 'connect.php';

// get $_POST params
$id = $_POST['id'];
$title = trim(htmlentities($_POST['title']));
$text = trim(htmlentities($_POST['text']));
$user = $_SESSION['userid'];

// update location
$checkExistingRecord = mysqli_query($connect, "SELECT * FROM `location` WHERE `id` = '$id'");

if (mysqli_num_rows($checkExistingRecord) > 0) {
  $updateRecord = mysqli_query($connect, "UPDATE `location` SET
        `title` = '$title',
        `text` = '$text',
        `user` = '$user'
        WHERE `id` = '$id'");
}

header("location:/?page=location");