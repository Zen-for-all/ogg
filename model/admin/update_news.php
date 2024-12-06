<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

// Check if the user is authorized (userId is 1)
if ($_SESSION['userId'] != 1) {
  header("Location: 404.php"); // Redirect to 404 page if unauthorized
  exit();
}

// Get and sanitize the input parameters from POST request
$id = intval($_POST['id']); // Ensure the news ID is an integer
$title = mysqli_real_escape_string($connect, trim($_POST['title'])); // Sanitize and trim the title input
$text = mysqli_real_escape_string($connect, trim($_POST['text'])); // Sanitize and trim the text input

// Prepare the SQL query to update the news in the database
$updateQuery = "UPDATE `news` SET `title` = ?, `text` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery); // Prepare the query for execution
$stmt->bind_param('ssi', $title, $text, $id); // Bind the parameters: 's' for string (title), 's' for string (text), 'i' for integer (id)
$stmt->execute(); // Execute the prepared statement

// Redirect back to the previous page or a specific page after the update
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
