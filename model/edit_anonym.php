<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require 'connect.php';

// Sanitize and validate POST input to check if 'anonym' is set and equals 'anonym', then set to 1, otherwise 0
$anonym = (isset($_POST['anonym']) && $_POST['anonym'] === 'anonym') ? 1 : 0;

// Ensure the user ID is an integer from the session
$id = (int)$_SESSION['userId'];

// Prepare the update query to set the 'anonym' status for the given user ID
$updateQuery = "UPDATE `user` SET `anonym` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery);

// Bind parameters to the query
$stmt->bind_param('ii', $anonym, $id);

// Execute the update query
$stmt->execute();

// Redirect to the settings page after the update
header("Location: /settings-net");
exit();
