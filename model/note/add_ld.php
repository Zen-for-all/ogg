<?php
session_start();
require '../connect.php';

// Get $_POST parameters
$date = date("d.m.y", strtotime($_POST['date']));
$time = $_POST['time'];
$duration = $_POST['duration'];
$location = $_POST['location'];
$quality = $_POST['quality'];
$interest = $_POST['interest'];
$method = $_POST['method'];
$text = trim(htmlentities($_POST['text']));
$publish = trim(htmlentities($_POST['publish']));
$notice = trim(htmlentities($_POST['notice']));
$public_text = trim(htmlentities($_POST['public_text']));
$user = $_SESSION['userid'];

// Add new learning and development entry
$setNewLd = mysqli_query($connect, "INSERT INTO `ld` (`date`, `time`, `duration`, `location`, `quality`, `interest`, `method`, `text`, `public_text`, `publish`, `notice`, `user`) VALUES ('$date', '$time', '$duration', '$location', '$quality', '$interest', '$method', '$text', '$public_text', '$publish', '$notice', '$user')");

// Get all user info from user ID
$result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
$resultldlist = mysqli_fetch_assoc($result);
$ldlist = json_decode($resultldlist['ldlist'], true); // Decode JSON into PHP array

// Get the last inserted learning and development entry ID
$result = mysqli_query($connect, "SELECT `id` FROM `ld` ORDER BY id DESC LIMIT 1;");
$ldlast = mysqli_fetch_assoc($result);
$ldnew = $ldlist; // Initialize new array for update

if (!empty($ldlist)) {
  $ldnew[] = $ldlast['id']; // Add new ID to array
} else {
  $ldnew = [$ldlast['id']]; // If array is empty, create new array with one element
}

$ldnew_json = json_encode($ldnew); // Encode array into JSON format

// Update learning and development list in user info
$setNewLdInUser = mysqli_query($connect, "UPDATE `user` SET `ldlist` = '$ldnew_json' WHERE `id` = '$user'");

header("location:/?page=journal");