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
$title = mysqli_real_escape_string($connect, trim($_POST['title'])); // Sanitize and trim the title input
$text = mysqli_real_escape_string($connect, trim($_POST['text'])); // Sanitize and trim the text input
$date = !empty($_POST['date']) ? strtotime($_POST['date']) : time(); // Use provided date or current timestamp
$admin = 1; // Set the admin field value to 1

// Prepare the SQL query to insert a new record into the news table
$insertQuery = "INSERT INTO `news` (`title`, `text`, `date`, `admin`) VALUES (?, ?, ?, ?)";
$stmt = $connect->prepare($insertQuery); // Prepare the query for execution
$stmt->bind_param('ssii', $title, $text, $date, $admin); // Bind the parameters: 's' for strings (title, text), 'i' for integers (date, admin)
$stmt->execute(); // Execute the prepared statement

// Redirect back to the previous page or a specific page after the creation
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
