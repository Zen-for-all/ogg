<?php
// Establish a database connection using mysqli
//$connect = mysqli_connect('localhost', 'root', '', 'ogg');
$connect = mysqli_connect('127.0.1.17', 'root', '', 'ogg');

// Check if the connection is successful
if (!$connect) {
  // Output error message and stop execution if the connection fails
  die('Problem connecting to DB: ' . mysqli_connect_error());
}
?>
