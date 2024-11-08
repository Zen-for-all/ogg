<?php
session_start();
require 'connect.php';

// Get and sanitize $_POST params
$email = mysqli_real_escape_string($connect, trim($_POST['email']));
$id = intval($_SESSION['userId']); // Ensure $id is an integer

// Update email
$updateQuery = "UPDATE `user` SET `email` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery);
$stmt->bind_param('si', $email, $id);
$stmt->execute();

// Redirect
header("Location: /?page=settings");
exit();