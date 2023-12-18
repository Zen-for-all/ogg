<?php
session_start();
require 'connect.php';

// get $_POST params
$password = trim(htmlentities($_POST['password']));
$id = $_SESSION['userid'];

// update password
$updateRecord = mysqli_query($connect, "UPDATE `user` SET `password` = '" . md5(md5($password)) . "' WHERE `id` = '$id'");

header("location:/?page=settings");