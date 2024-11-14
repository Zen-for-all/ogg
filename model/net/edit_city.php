<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

// Get and sanitize the city from POST request
$city = $_POST['city']; // Get the city from the form submission
$id = intval($_SESSION['userId']); // Ensure the user ID is an integer

// Prepare the SQL query to update the city in the database
$updateQuery = "UPDATE `user` SET `city` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery); // Prepare the query for execution
$stmt->bind_param('si', $city, $id); // Bind the parameters: 's' for string (city), 'i' for integer (user ID)
$stmt->execute(); // Execute the prepared statement

// Redirect the user to the settings page after the update
header("Location: /settings-net");
exit();
