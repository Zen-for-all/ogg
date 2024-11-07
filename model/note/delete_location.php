<?php
session_start();
require '../connect.php';

$user = $_SESSION['userId'];
$locationId = $_POST['delete'];

// Delete location from location table
$deleteLdLocation = mysqli_query($connect, "DELETE FROM `location` WHERE `id` = '$locationId'");

// Fetch user data
$result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
$resultldlist = mysqli_fetch_assoc($result);

// Decode the user's locations array
$ldLocations = $resultldlist['ldlocations'];
$locationArray = $ldLocations ? json_decode($ldLocations, true) : [];

// Find and remove the location id from the array
$key = array_search($locationId, $locationArray, true);
if ($key !== false) {
  unset($locationArray[$key]);
}

// Encode the updated locations array as JSON
$locationNew = json_encode(array_values($locationArray));

// Update the user's ldlocations field with the new array
$updateUserLocationList = mysqli_query($connect, "UPDATE `user` SET `ldlocations` = '$locationNew' WHERE `id` = '$user'");

// Update ld table to nullify the location reference
$deleteFromLd = mysqli_query($connect, "UPDATE `ld` SET `location` = NULL WHERE `location` = '$locationId'");

// Redirect to the location page
header("location:/?page=location");