<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

// Retrieve form data and user session
$title = $_POST['title'] ?? '';  // Title of the location
$text = $_POST['text'] ?? '';    // Text description of the location
$user = $_SESSION['userId'] ?? null; // User ID from session

// Check if the title is not empty
if ($title !== '') {
  // Insert new location into the database
  $setNewLocation = mysqli_query($connect, "INSERT INTO `location` (`title`, `text`, `user`) VALUES ('$title', '$text', '$user')");

  // Fetch user data to update their locations
  $result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
  $resultLdLocation = mysqli_fetch_assoc($result);

  // Get the user's current locations, or initialize as an empty array
  $ldLocation = $resultLdLocation['ldlocations'];
  $ldLocationArray = $ldLocation ? json_decode($ldLocation, true) : [];

  // Fetch the ID of the last inserted location
  $result = mysqli_query($connect, "SELECT `id` FROM `location` ORDER BY id DESC LIMIT 1;");
  $locationLast = mysqli_fetch_assoc($result);

  // Add the new location's ID to the user's locations array
  $ldLocationArray[] = $locationLast['id'];

  // Encode the updated locations array to JSON
  $locationNew = json_encode($ldLocationArray);

  // Update the user's `ldlocations` field with the new array of location IDs
  $setNewLocationInUser = mysqli_query($connect, "UPDATE `user` SET `ldlocations` = '$locationNew' WHERE `id` = '$user'");
}

// Redirect to the location page
header("Location:/location");
exit();
