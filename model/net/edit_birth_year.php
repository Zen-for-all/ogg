<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

// Get and sanitize the birth year from POST request
$birth_year = intval($_POST['birth_year']); // Ensure the birth year is an integer
$id = intval($_SESSION['userId']); // Ensure the user ID is an integer

// Prepare the SQL query to update the birth year in the database
$updateQuery = "UPDATE `user` SET `birth_year` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery); // Prepare the query for execution
$stmt->bind_param('ii', $birth_year, $id); // Bind the parameters: 'i' for integer (birth year), 'i' for integer (user ID)
$stmt->execute(); // Execute the prepared statement

// Redirect the user to the settings page after the update
header("Location: /settings-net");
exit();
