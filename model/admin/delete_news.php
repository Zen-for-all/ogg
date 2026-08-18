<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */

session_start();
require '../connect.php';

// Check if the user is authorized (userId is 1)
if ($_SESSION['userId'] != 1) {
  header("Location: 404.php"); // Redirect to 404 page if unauthorized
  exit();
}

// Get and sanitize the input parameter from POST request
$id = intval($_POST['id']); // Ensure the news ID is an integer

// Prepare the SQL query to delete the news from the database
$deleteQuery = "DELETE FROM `news` WHERE `id` = ?";
$stmt = $connect->prepare($deleteQuery); // Prepare the query for execution
$stmt->bind_param('i', $id); // Bind the parameter: 'i' for integer (id)
$stmt->execute(); // Execute the prepared statement

// Redirect back to the previous page or a specific page after the deletion
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
