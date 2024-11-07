<?php
session_start();
require 'connect.php';

// Sanitize and hash the password
$password = $_POST['password'] ?? '';
$hashedPassword = md5(md5(trim($password))); // Note: Consider using more secure hashing methods like bcrypt

// Ensure the user ID is an integer
$id = (int)$_SESSION['userId'];

// Prepare and execute the update query
$updateQuery = "UPDATE `user` SET `password` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery);
$stmt->bind_param('si', $hashedPassword, $id);
$stmt->execute();

// Redirect
header("Location: /?page=settings");
exit();