<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

// Ensure the user is logged in
if (!isset($_SESSION['userId'])) {
  header("Location: /login");
  exit();
}

// Get the user ID from the session
$id = intval($_SESSION['userId']); // Ensure the user ID is an integer

// Get the selected ideology from the POST data (if set)
$selectedIdeology = isset($_POST['ideology']) ? intval($_POST['ideology']) : 0;

// Prepare the SQL query to update the user's ideology field
$updateQuery = "UPDATE `user` SET `ideology` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery); // Prepare the query for execution
$stmt->bind_param('ii', $selectedIdeology, $id); // Bind the parameters: 'i' for integer (ideology), 'i' for integer (user ID)
$stmt->execute(); // Execute the prepared statement

// Redirect the user back to the settings page after the update
header("Location: /settings-net");
exit();
