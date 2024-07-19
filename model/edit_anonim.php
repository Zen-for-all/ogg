<?php
session_start();
require 'connect.php';

// Sanitize and validate POST input
$anonym = isset($_POST['anonym']) && $_POST['anonym'] === 'anonym' ? 1 : 0;

// Ensure the user ID is an integer
$id = (int)$_SESSION['userid'];

// Prepare and execute the update query
$updateQuery = "UPDATE `user` SET `anonym` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery);
$stmt->bind_param('ii', $anonym, $id);
$stmt->execute();

// Redirect
header("Location: /?page=settings");
exit();