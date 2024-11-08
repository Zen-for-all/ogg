<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

// Get the user ID from the session and the 'ld' ID from the POST request
$user = $_SESSION['userId'];
$ldId = $_POST['delete'];

// Delete the item from the 'ld' table using the provided 'ldId'
$deleteLd = mysqli_query($connect, "DELETE FROM `ld` WHERE `id` = '$ldId'");

// Fetch the user's record from the 'user' table to get their 'ldlist'
$result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
$resultldlist = mysqli_fetch_assoc($result); // Fetch the user's data as an associative array

// Decode the 'ldlist' from JSON into an array. If not a valid array, initialize it as an empty array
$ldlist = json_decode($resultldlist['ldlist'], true);
if (!is_array($ldlist)) {
  $ldlist = []; // Initialize as an empty array if 'ldlist' is not valid
}

// Search for the 'ldId' in the 'ldlist' and remove it if found
$key = array_search($ldId, $ldlist, true);
if ($key !== false) {
  array_splice($ldlist, $key, 1); // Remove the item from the 'ldlist' array
}

// Encode the updated 'ldlist' back to JSON format
$ldNew = json_encode($ldlist);

// Update the user's 'ldlist' in the database with the new JSON-encoded value
$updateUserLdList = mysqli_query($connect, "UPDATE `user` SET `ldlist` = '$ldNew' WHERE `id` = '$user'");

// Redirect the user back to the journal page
header("location:/journal");
exit();
