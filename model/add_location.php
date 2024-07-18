<?php
session_start();
require 'connect.php';

$title = $_POST['title'];
$text = $_POST['text'];
$user = $_SESSION['userid'];

if ($title == '') {
  // If the title is empty, do nothing
} else {
  // Insert new location into the database
  $setNewLocation = mysqli_query($connect, "INSERT INTO `location` (`title`, `text`, `user`) VALUES ('$title', '$text', '$user')");

  // Fetch user data
  $result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
  $resultLdLocation = mysqli_fetch_assoc($result);

  // Get current locations array or initialize as an empty array
  $ldLocation = $resultLdLocation['ldlocations'];
  $ldLocationArray = $ldLocation ? json_decode($ldLocation, true) : [];

  // Fetch the last inserted location id
  $result = mysqli_query($connect, "SELECT `id` FROM `location` ORDER BY id DESC LIMIT 1;");
  $locationLast = mysqli_fetch_assoc($result);

  // Add the new location id to the array
  $ldLocationArray[] = $locationLast['id'];

  // Encode the updated locations array as JSON
  $locationNew = json_encode($ldLocationArray);

  // Update the user's ldlocations field with the new array
  $setNewLocationInUser = mysqli_query($connect, "UPDATE `user` SET `ldlocations` = '$locationNew' WHERE `id` = '$user'");
}

// Redirect to the location page
header("location:/?page=location");