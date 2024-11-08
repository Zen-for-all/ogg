<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require 'connect.php';

$userId = (int)$_SESSION['userId'];

// Prepare the queries for deleting the user's data
$queries = [
  "DELETE FROM `location` WHERE `user` = ?",  // Delete location records for the user
  "DELETE FROM `ld` WHERE `user` = ?",        // Delete ld records for the user
  "DELETE FROM `user` WHERE `id` = ?"         // Delete the user from the user table
];

// Loop through each query, prepare, and execute the deletion
foreach ($queries as $query) {
  // Prepare the SQL query to prevent SQL injection
  $stmt = $connect->prepare($query);

  // Bind the user ID parameter to the query
  $stmt->bind_param('i', $userId);

  // Execute the query
  $stmt->execute();
}

// Clear the session data and destroy the session to log the user out
session_unset();  // Removes all session variables
session_destroy();  // Destroys the session

// Redirect the user to the homepage after account deletion
header("Location: /");
exit();
