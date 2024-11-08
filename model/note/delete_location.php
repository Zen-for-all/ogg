<?php
/**
 * @var object $connect The database connection object used to interact with the MySQL database.
 */
?>

<?php
session_start();
require '../connect.php';

$user = $_SESSION['userId'];
$locationId = $_POST['delete'];

// Delete the location from the 'location' table
$deleteLdLocation = mysqli_query($connect, "DELETE FROM `location` WHERE `id` = '$locationId'");

// Fetch the user data based on the user ID
$result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
$resultldlist = mysqli_fetch_assoc($result);

// Decode the user's locations array from the database
$ldLocations = $resultldlist['ldlocations'];
$locationArray = $ldLocations ? json_decode($ldLocations, true) : [];  // Decode JSON or initialize an empty array

// Search for the location ID in the user's locations array
$key = array_search($locationId, $locationArray, true);

// If the location ID is found in the array, remove it
if ($key !== false) {
  unset($locationArray[$key]);
}

// Re-index the array and encode it back to JSON format
$locationNew = json_encode(array_values($locationArray));

// Update the user's 'ldlocations' field with the new list of locations
$updateUserLocationList = mysqli_query($connect, "UPDATE `user` SET `ldlocations` = '$locationNew' WHERE `id` = '$user'");

// Update the 'ld' table to remove the reference to the deleted location
$deleteFromLd = mysqli_query($connect, "UPDATE `ld` SET `location` = NULL WHERE `location` = '$locationId'");

// Redirect to the location page after the deletion
header("location:/location");
exit();
