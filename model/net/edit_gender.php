<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

// Get and sanitize the gender parameter from POST request
$gender = mysqli_real_escape_string($connect, trim($_POST['gender'])); // Sanitize and trim the gender input
$id = intval($_SESSION['userId']); // Ensure the user ID is an integer

// If no gender is selected (empty value), set it to NULL or empty string (based on your requirement)
if ($gender === '') {
  $gender = NULL;  // Or use $gender = ''; to store an empty string instead of NULL
}

// Prepare the SQL query to update the gender in the database
$updateQuery = "UPDATE `user` SET `gender` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery); // Prepare the query for execution
$stmt->bind_param('si', $gender, $id); // Bind the parameters: 's' for string (gender), 'i' for integer (id)
$stmt->execute(); // Execute the prepared statement

// Redirect the user to the settings page after the update
header("Location: /?page=settings-net");
exit();
