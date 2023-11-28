<?php
session_start();
require 'connect.php';

$user = $_SESSION['userid'];
$locationId = $_POST['delete'];

$deleteLd = mysqli_query($connect, "DELETE FROM `location` WHERE `id` = '$locationId'");

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

header("location:/?page=location");