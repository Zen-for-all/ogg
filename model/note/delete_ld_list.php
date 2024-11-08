<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

$user = $_SESSION['userId'];

// Delete records from the `ld` table where the `user` column matches the current user ID.
$deleteLd = mysqli_query($connect, "DELETE FROM `ld` WHERE `user` = '$user'");

// Update the `ldlist` field in the `user` table to NULL for the current user.
$deleteLdId = mysqli_query($connect, "UPDATE `user` SET `ldlist` = NULL WHERE `id` = '$user'");

// Redirect to the journal page after processing.
header("location:/journal");
exit();
