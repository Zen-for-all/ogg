<?php
session_start();
require '../connect.php';

$user = $_SESSION['userId'];
$ldId = $_POST['delete'];

$deleteLd = mysqli_query($connect, "DELETE FROM `ld` WHERE `id` = '$ldId'");

$result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
$resultldlist = mysqli_fetch_assoc($result);
$ldlist = json_decode($resultldlist['ldlist'], true);

if (!is_array($ldlist)) {
  $ldlist = [];
}

$key = array_search($ldId, $ldlist, true);
if ($key !== false) {
  array_splice($ldlist, $key, 1); // Remove the element from the array
}

$ldNew = json_encode($ldlist);

$updateUserLdList = mysqli_query($connect, "UPDATE `user` SET `ldlist` = '$ldNew' WHERE `id` = '$user'");

header("location:/?page=journal");