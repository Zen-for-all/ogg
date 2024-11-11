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

// Remove the user ID from the user lists in the `groups` table
$result = $connect->query("SELECT `id`, `users` FROM `groups`");
while ($group = $result->fetch_assoc()) {
  // Decode the list of users for the group
  $users = json_decode($group['users'], true);

  // If the user's ID is found in the group's user list, remove it
  if (($key = array_search($userId, $users, true)) !== false) {
    array_splice($users, $key, 1);  // Remove the user ID from the array

    // Convert the updated user list back to JSON format
    $updatedUsers = json_encode($users);

    // Prepare the query to update the `users` list in the group
    $stmt = $connect->prepare("UPDATE `groups` SET `users` = ? WHERE `id` = ?");
    $stmt->bind_param('si', $updatedUsers, $group['id']);

    // Execute the update query
    $stmt->execute();
  }
}

// Clear the session data and destroy the session to log the user out
session_unset();
session_destroy();

// Redirect the user to the homepage after account deletion
header("Location: /");
exit();
