<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

// Get and sanitize the ldcount from POST request
$ldcount = intval($_POST['ldcount']); // Ensure the ldcount is an integer
$id = intval($_SESSION['userId']); // Ensure the user ID is an integer

// Prepare the SQL query to update the ldcount in the database
$updateQuery = "UPDATE `user` SET `ldcount` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery); // Prepare the query for execution
$stmt->bind_param('ii', $ldcount, $id); // Bind the parameters: 'i' for integer (ldcount), 'i' for integer (user ID)
$stmt->execute(); // Execute the prepared statement

// Redirect the user to the settings page after the update
header("Location: /settings-net");
exit();
