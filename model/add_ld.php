<?php
session_start();
require 'connect.php';

// get $_POST params
$date = $_POST['date'];
$time = $_POST['time'];
$duration = $_POST['duration'];
$location = $_POST['location'];
$quality = $_POST['quality'];
$interest = $_POST['interest'];
$method = $_POST['method'];
$text = trim(htmlentities($_POST['text']));
$notice = trim(htmlentities($_POST['notice']));
$user = $_SESSION['userid'];

// add new ld
$setNewLd = mysqli_query($connect, "INSERT INTO `ld` (`date`, `time`, `duration`, `location`, `quality`, `interest`, `method`, `text`, `notice`, `user`) VALUES ('$date', '$time', '$duration', '$location', '$quality', '$interest', '$method', '$text', '$notice', '$user')");

// get all user info from id
$result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
$resultldlist = mysqli_fetch_assoc($result);
$ldlist = $resultldlist['ldlist'];

// get & edit ld list
$result = mysqli_query($connect, "SELECT `id` FROM `ld` ORDER BY id DESC LIMIT 1;");
$ldlast = mysqli_fetch_assoc($result);
$ldnew = $ldlist . ' ' . $ldlast['id'];

// update ld list in user info
$setNewLdInUser = mysqli_query($connect, "UPDATE `user` SET `ldlist` = '$ldnew' WHERE `id` = '$user'");

header("location:/?page=journal");