<?php
session_start();
require 'connect.php';

$user = $_SESSION['userid'];
$locationId = $_POST['delete'];

// delete location in location list
$deleteLd = mysqli_query($connect, "DELETE FROM `location` WHERE `id` = '$locationId'");

// delete location in user info
$result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
$resultldlist = mysqli_fetch_assoc($result);
$ldLocations = trim($resultldlist['ldlocations']);
$locationArray = explode(" ", trim($ldLocations));
$key = array_search($locationId, $locationArray, true);
if ($key !== false) {
  unset($locationArray[$key]);
}
$locationNew = implode(' ', $locationArray);
$updateUserLocationList = mysqli_query($connect, "UPDATE `user` SET `ldlocations` = '$locationNew' WHERE `id` = '$user'");

// delete location in ld list
$deleteFromLd = mysqli_query($connect, "UPDATE `ld` SET `location` = NULL WHERE `location` = '$locationId'");

header("location:/?page=location");