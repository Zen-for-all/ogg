<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

// Get and sanitize the description from the POST request
$description = isset($_POST['description']) ? trim($_POST['description']) : ''; // Ensure we have a valid description
$id = intval($_SESSION['userId']); // Get the user ID from the session and ensure it's an integer

// Prepare the SQL query to update the description in the database
$updateQuery = "UPDATE `user` SET `description` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery); // Prepare the query for execution

// Bind the parameters: 's' for string (description), 'i' for integer (user ID)
$stmt->bind_param('si', $description, $id);

// Execute the prepared statement
$stmt->execute();

// Redirect the user to the settings page after the update
header("Location: /settings-net");
exit();
