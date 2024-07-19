<?php
session_start();
require 'connect.php';

// Sanitize and hash the input
$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';
$hashedPassword = md5(md5(trim($password))); // Note: Consider using more secure hashing methods like bcrypt

// Prepare and execute the query
$login = trim(htmlspecialchars($login)); // Sanitize login input
$updateQuery = "SELECT `id` FROM `user` WHERE `login` = ? AND `password` = ?";
$stmt = $connect->prepare($updateQuery);
$stmt->bind_param('ss', $login, $hashedPassword);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
  $_SESSION['userid'] = $user['id'];
  setcookie("userid", $user['id'], time() + (86400 * 30), "/"); // Set cookie for 30 days
} else {
  $_SESSION['logError'] = 1;
}

// Redirect
header("Location: /");
exit();