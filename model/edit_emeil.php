<?php
session_start();
require 'connect.php';

// get $_POST params
$email = trim(htmlentities($_POST['email']));
$id = $_SESSION['userid'];

// update email
$updateRecord = mysqli_query($connect, "UPDATE `user` SET `email` = '$email' WHERE `id` = '$id'");

header("location:/?page=settings");
