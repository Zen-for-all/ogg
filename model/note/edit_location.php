<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

// Get and sanitize input parameters from the POST request
$id = isset($_POST['id']) ? $_POST['id'] : ''; // Location ID
$title = isset($_POST['title']) ? trim(htmlentities($_POST['title'])) : ''; // Title of the location
$text = isset($_POST['text']) ? trim(htmlentities($_POST['text'])) : ''; // Text content of the location
$user = isset($_SESSION['userId']) ? $_SESSION['userId'] : ''; // User ID from the session

// Check if the record with the given ID exists in the location table
$query = "SELECT * FROM `location` WHERE `id` = '$id'";
$checkExistingRecord = mysqli_query($connect, $query);

if ($checkExistingRecord && mysqli_num_rows($checkExistingRecord) > 0) {
  // Update the location record if it exists
  $updateQuery = "UPDATE `location` SET
        `title` = '$title',
        `text` = '$text',
        `user` = '$user'
        WHERE `id` = '$id'";

  // Execute the update query
  mysqli_query($connect, $updateQuery);
}

// Redirect to the location page after updating the record
header("location:/location");
exit();
