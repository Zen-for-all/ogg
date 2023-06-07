<?php
session_start();
require 'connect.php';

$login = trim(htmlentities($_POST['login']));
$email = trim(htmlentities($_POST['email']));
$password = trim(htmlentities($_POST['password']));
$date = date('Y-m-d');
$anonym = $_POST['anonym'];
if ($anonym == null) {
  $anonym = 0;
} else {
  $anonym = 1;
}

$result = mysqli_query($connect, "SELECT `id` FROM `user` WHERE `login` = '$login'");
$resultId = mysqli_fetch_assoc($result);

if (!($login) || !($email) || !($password)){
  $_SESSION['regError'] = 3; // error - empty input
  header("location:/?page=signing");
} elseif (strlen($login) > 20 || strlen($login) < 3){
  $_SESSION['regError'] = 2; // error - login very short or long
  header("location:/?page=signing");
} elseif ($resultId != null) {
  $_SESSION['regError'] = 1; // error - user name exist
  header("location:/?page=signing");
} else { // if all ok
  $setNewUser = mysqli_query($connect, "INSERT INTO `user` (`login`, `password`, `email`, `date`, `anonym`) VALUES ('$login', '" . md5(md5($password)) . "', '$email', '$date', '$anonym')");
  $resultId = mysqli_query($connect, "SELECT `id` FROM `user` WHERE `login` = '$login'");
  $newUser = mysqli_fetch_assoc($resultId);
  $_SESSION['userid'] = $newUser['id'];

  header("location:/");
}