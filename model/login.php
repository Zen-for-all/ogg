<?php
session_start();
require 'connect.php';

$login = trim(htmlentities($_POST['login']));
$password = trim(htmlentities($_POST['password']));

$result = mysqli_query($connect, "SELECT `id` FROM `user` WHERE `login` = '$login' AND `password` = '" . md5(md5($password)) . "'");
$user = mysqli_fetch_assoc($result);

if ($user) {
  $_SESSION['userid'] = $user['id'];
  setcookie("userid", $user['id'], time() + (86400 * 30), "/"); // Устанавливаем куки на 30 дней
} else {
  $_SESSION['logError'] = 1;
}

header("location:/");
