<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require 'connect.php';

// Get the user inputs and sanitize them
$login = isset($_POST['login']) ? trim(htmlspecialchars($_POST['login'])) : ''; // Sanitize login input
$password = isset($_POST['password']) ? trim($_POST['password']) : ''; // Trim and get password input
$hashedPassword = md5(md5($password)); // Note: MD5 is not recommended for hashing passwords, consider using bcrypt or Argon2

// Prepare the SQL query to fetch user data based on login and hashed password
$query = "SELECT `id` FROM `user` WHERE `login` = ? AND `password` = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param('ss', $login, $hashedPassword);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user was found
$user = $result->fetch_assoc();

// If user found, store user ID in session and set a cookie for 30 days
if ($user) {
  $_SESSION['userId'] = $user['id'];
  setcookie("userId", $user['id'], time() + (86400 * 30), "/"); // Set a cookie to remember the user for 30 days
} else {
  // If no user found, set an error flag in session
  $_SESSION['logError'] = 1;
}

// Redirect to the homepage after processing
header("Location: /");
exit();
