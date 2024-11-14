<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

// Get and sanitize the experience value from the POST request
$experience = intval($_POST['experience']); // Ensure the experience is an integer
$id = intval($_SESSION['userId']); // Ensure the user ID is an integer

// Prepare the SQL query to update the experience in the database
$updateQuery = "UPDATE `user` SET `experience` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery); // Prepare the query for execution
$stmt->bind_param('ii', $experience, $id); // Bind the parameters: 'i' for integer (experience), 'i' for integer (user ID)
$stmt->execute(); // Execute the prepared statement

// Redirect the user to the settings page after the update
header("Location: /settings-net");
exit();
