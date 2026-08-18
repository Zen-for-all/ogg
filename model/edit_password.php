<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */

session_start();
require 'connect.php';

// Sanitize and hash the password
$password = $_POST['password'] ?? '';  // Get the password from POST request, default to an empty string if not set
$hashedPassword = md5(md5(trim($password)));  // Hash the password. Note: md5 is not secure, consider using bcrypt or Argon2 for better security

// Ensure the user ID is an integer
$id = (int)$_SESSION['userId'];  // Safely cast user ID to an integer

// Prepare the update query to change the password in the database
$updateQuery = "UPDATE `user` SET `password` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery);  // Prepare the SQL statement
$stmt->bind_param('si', $hashedPassword, $id);  // Bind the hashed password and user ID to the query
$stmt->execute();  // Execute the query to update the password

// Redirect the user to the settings page
header("Location: /settings");
exit();
