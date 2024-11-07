<?php
session_start();
require 'connect.php';

// Ensure the user ID is an integer
$userId = (int)$_SESSION['userId'];

// Prepare and execute delete queries
$queries = [
  "DELETE FROM `location` WHERE `user` = ?",
  "DELETE FROM `ld` WHERE `user` = ?",
  "DELETE FROM `user` WHERE `id` = ?"
];

foreach ($queries as $query) {
  $stmt = $connect->prepare($query);
  $stmt->bind_param('i', $userId);
  $stmt->execute();
}

// Clear session and redirect
session_unset();
session_destroy();
header("Location: /");
exit();