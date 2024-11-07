<?php
session_start();
require 'connect.php';

// Sanitize and validate input
$login = trim(htmlspecialchars($_POST['login'] ?? ''));
$email = trim(htmlspecialchars($_POST['email'] ?? ''));
$password = trim(htmlspecialchars($_POST['password'] ?? ''));
$date = date('Y-m-d');
$anonym = isset($_POST['anonym']) ? 1 : 0; // Convert to integer

// Prepare and execute queries
// Check if login already exists
$loginQuery = "SELECT `id` FROM `user` WHERE `login` = ?";
$stmt = $connect->prepare($loginQuery);
if (!$stmt) {
  die('Prepare failed: ' . $connect->error);
}
$stmt->bind_param('s', $login);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
  die('Query failed: ' . $stmt->error);
}

$resultId = $result->fetch_assoc();

// Validate input
if (!$login || !$email || !$password) {
  $_SESSION['regError'] = 3; // Error - empty input
  header("Location: /?page=signing");
  exit();
} elseif (strlen($login) > 20 || strlen($login) < 3) {
  $_SESSION['regError'] = 2; // Error - login very short or long
  header("Location: /?page=signing");
  exit();
} elseif ($resultId) {
  $_SESSION['regError'] = 1; // Error - user name exists
  header("Location: /?page=signing");
  exit();
} else {
  // Insert new user
  $hashedPassword = md5(md5($password)); // Note: Consider using a more secure hashing method like bcrypt
  $insertQuery = "INSERT INTO `user` (`login`, `password`, `email`, `date`, `anonym`) VALUES (?, ?, ?, ?, ?)";
  $stmt = $connect->prepare($insertQuery);
  if (!$stmt) {
    die('Prepare failed: ' . $connect->error);
  }
  $stmt->bind_param('ssssi', $login, $hashedPassword, $email, $date, $anonym);
  $stmt->execute();

  if ($stmt->affected_rows === 0) {
    die('Insert failed: ' . $stmt->error);
  }

  // Retrieve new user ID
  $stmt->close(); // Close the previous statement
  $loginQuery = "SELECT `id` FROM `user` WHERE `login` = ?";
  $stmt = $connect->prepare($loginQuery);
  if (!$stmt) {
    die('Prepare failed: ' . $connect->error);
  }
  $stmt->bind_param('s', $login);
  $stmt->execute();
  $result = $stmt->get_result();
  $newUser = $result->fetch_assoc();

  if ($newUser) {
    $_SESSION['userId'] = $newUser['id'];
  } else {
    die('User retrieval failed.');
  }

  header("Location: /");
  exit();
}