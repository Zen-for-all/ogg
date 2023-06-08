<?php
session_start();
require 'connect.php';

$title = $_POST['title'];
$text = $_POST['text'];
$user = $_SESSION['userid'];

if ($title == '') {
  // empty
} else {
  $setNewLocation = mysqli_query($connect, "INSERT INTO `location` (`title`, `text`, `user`) VALUES ('$title', '$text', '$user')");

  $result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
  $resultLdLocation = mysqli_fetch_assoc($result);
  $ldLocation = $resultLdLocation['ldlocations'];

  $result = mysqli_query($connect, "SELECT `id` FROM `location` ORDER BY id DESC LIMIT 1;");
  $locationLast = mysqli_fetch_assoc($result);
  $locationNew = $ldLocation . ' ' . $locationLast['id'];

  $setNewLocationInUser = mysqli_query($connect, "UPDATE `user` SET `ldlocations` = '$locationNew' WHERE `id` = '$user'");
}

header("location:/?page=location");