<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

// Set the character set for the database connection to utf8mb4
mysqli_set_charset($connect, "utf8mb4");

$user = $_SESSION['userId'];

// Set the headers for downloading a TSV file
header('Content-Type: text/tab-separated-values');
header('Content-Disposition: attachment; filename="export.tsv"');

// Open the output stream for writing the file
$output = fopen('php://output', 'w');

// Define the columns to be included in the TSV file
$columns = ["Date", "Time", "Duration", "Location", "Quality", "Interest", "Method", "Text", "Notice"];
// Write the column headers to the output file
fputcsv($output, $columns, "\t");

// Prepare the SQL query to fetch data from the 'ld' table for the current user
$query = mysqli_query($connect, "SELECT `date`, `time`, `duration`, `location`, `quality`, `interest`, `method`, `text`, `notice` FROM `ld` WHERE `user` = '$user'");

// Loop through the results and format the date, then write each row to the output file
while ($row = mysqli_fetch_assoc($query)) {
  // Convert the date format from 'd.m.y' to 'd.m.y'
  $row['date'] = DateTime::createFromFormat('d.m.y', $row['date'])->format('d.m.y');
  // Write the row data to the output file
  fputcsv($output, $row, "\t");
}

// Close the output file stream
fclose($output);

exit();
