<?php
session_start();
require 'connect.php';

// get $_POST params
if ($_POST['anonym'] === 'anonym') {
  $anonym = 1;
} else {
  $anonym = 0;
}

$id = $_SESSION['userid'];

// update anonym
$updateRecord = mysqli_query($connect, "UPDATE `user` SET `anonym` = '$anonym' WHERE `id` = '$id'");

header("location:/?page=settings");