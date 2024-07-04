<?php
session_start();
require 'connect.php';

$user = $_SESSION['userid'];

$deleteLd = mysqli_query($connect, "DELETE FROM `ld` WHERE `user` = '$user'");

$deleteLdId = mysqli_query($connect, "UPDATE `user` SET `ldlist` = '' WHERE `id` = '$user'");

header("location:/?page=journal");