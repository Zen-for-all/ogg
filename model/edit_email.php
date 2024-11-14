<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require 'connect.php';

// Get and sanitize the email parameter from POST request
$email = mysqli_real_escape_string($connect, trim($_POST['email'])); // Sanitize and trim the email input
$id = intval($_SESSION['userId']); // Ensure the user ID is an integer

// Prepare the SQL query to update the email in the database
$updateQuery = "UPDATE `user` SET `email` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery); // Prepare the query for execution
$stmt->bind_param('si', $email, $id); // Bind the parameters: 's' for string (email), 'i' for integer (id)
$stmt->execute(); // Execute the prepared statement

// Redirect the user to the settings page after the update
header("Location: /settings");
exit();
