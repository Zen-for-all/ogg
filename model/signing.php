<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require 'connect.php';

// Sanitize and validate input
$login = trim(htmlspecialchars($_POST['login'] ?? ''));
$email = trim(htmlspecialchars($_POST['email'] ?? ''));
$password = trim(htmlspecialchars($_POST['password'] ?? ''));
$date = date('Y-m-d');
$anonym = isset($_POST['anonym']) ? 1 : 0; // Convert to integer

// Validate input fields before proceeding
if (!$login || !$email || !$password) {
  $_SESSION['regError'] = 3; // Error - empty input
  header("Location: /?page=signing");
  exit();
} elseif (strlen($login) > 20 || strlen($login) < 3) {
  $_SESSION['regError'] = 2; // Error - login too short or too long
  header("Location: /?page=signing");
  exit();
}

// Prepare query to check if the login already exists
$loginQuery = "SELECT `id` FROM `user` WHERE `login` = ?";
$stmt = $connect->prepare($loginQuery);
if (!$stmt) {
  die('Prepare failed: ' . $connect->error); // Error preparing the query
}
$stmt->bind_param('s', $login);
$stmt->execute();
$result = $stmt->get_result();

// Check if the login is already taken
if ($result && $result->num_rows > 0) {
  $_SESSION['regError'] = 1; // Error - user with this login exists
  header("Location: /?page=signing");
  exit();
}

// Hash password securely (consider using bcrypt or Argon2 for better security)
$hashedPassword = md5(md5($password)); // This method is insecure, switch to bcrypt or Argon2

// Prepare query to insert the new user
$insertQuery = "INSERT INTO `user` (`login`, `password`, `email`, `date`, `anonym`) VALUES (?, ?, ?, ?, ?)";
$stmt = $connect->prepare($insertQuery);
if (!$stmt) {
  die('Prepare failed: ' . $connect->error); // Error preparing the insert query
}
$stmt->bind_param('ssssi', $login, $hashedPassword, $email, $date, $anonym);
$stmt->execute();

// Check if the user was inserted successfully
if ($stmt->affected_rows === 0) {
  die('Insert failed: ' . $stmt->error); // Error inserting the user into the database
}

// Retrieve new user's ID after insertion
$stmt->close(); // Close the previous statement
$loginQuery = "SELECT `id` FROM `user` WHERE `login` = ?";
$stmt = $connect->prepare($loginQuery);
if (!$stmt) {
  die('Prepare failed: ' . $connect->error); // Error preparing the query to retrieve user
}
$stmt->bind_param('s', $login);
$stmt->execute();
$result = $stmt->get_result();
$newUser = $result->fetch_assoc();

// Check if the new user was retrieved successfully
if ($newUser) {
  $_SESSION['userId'] = $newUser['id']; // Store the user ID in the session
} else {
  die('User retrieval failed.'); // Error retrieving the user after creation
}

// Redirect to the homepage after successful registration
header("Location: /");
exit();