<?php
session_start();
require 'connect.php';

$user = $_SESSION['userid'];
$ldId = $_POST['delete'];

$deleteLd = mysqli_query($connect, "DELETE FROM `ld` WHERE `id` = '$ldId'");

$result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
$resultldlist = mysqli_fetch_assoc($result);
$ldlist = trim($resultldlist['ldlist']);
$ldArray = explode(" ", trim($ldlist));

$key = array_search($ldId, $ldArray, true);
if ($key !== false) {
  unset($ldArray[$key]);
}

$ldNew = implode(' ', $ldArray);

$updateUserLdList = mysqli_query($connect, "UPDATE `user` SET `ldlist` = '$ldNew' WHERE `id` = '$user'");

header("location:/?page=journal");