<?php
/**
 * @var object $connect The database connection object used to interact with the MySQL database.
 */

session_start();
require '../connect.php';

$user = $_SESSION['userId'];

// Delete all locations associated with the current user from the `location` table.
$deleteLd = mysqli_query($connect, "DELETE FROM `location` WHERE `user` = '$user'");

// This action effectively removes the location data from the user profile.
$deleteLdId = mysqli_query($connect, "UPDATE `user` SET `ldlocations` = NULL WHERE `id` = '$user'");

// Redirect the user to the 'location' page after the operations
header("Location: /location");

// Terminate the script execution to prevent further processing
exit();
