<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

// Set the character encoding for the connection to UTF-8
mysqli_set_charset($connect, "utf8mb4");

$user = $_SESSION['userId'];

// Initialize the array to store the parsed data
$array_ld = [];

// Process the uploaded file when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["upload_txt"])) {
  // Check if the file is uploaded without errors
  if (isset($_FILES["txt_file"]) && $_FILES["txt_file"]["error"] == UPLOAD_ERR_OK) {
    // Get the content of the uploaded file
    $txt_content = file_get_contents($_FILES["txt_file"]["tmp_name"]);

    // Define the delimiter (tab character)
    $delimiter = "\t";

    // Create a temporary file and write the content into it
    $tempFile = tempnam(sys_get_temp_dir(), 'txt_temp');
    file_put_contents($tempFile, $txt_content);

    // Open the temporary file for reading
    $handle = fopen($tempFile, "r");
    if ($handle) {
      // Loop through the file and read each line as a CSV
      while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
        // Add each row of data to the array
        $array_ld[] = $data;
      }
      // Close the file handle after processing
      fclose($handle);
    }

    // Delete the temporary file after use
    unlink($tempFile);
  } else {
    // Display an error if file upload failed
    echo "Error uploading file.";
  }
}

// Loop through the parsed data and insert valid records into the database
foreach ($array_ld as $ld) {
  // Validate data fields to ensure they are numeric or empty, skip invalid rows
  if (!preg_match('/^\d*\.?\d*$/', $ld[2]) && $ld[2] !== '-' && $ld[2] !== '') continue;
  if (!preg_match('/^\d*\.?\d*$/', $ld[4]) && $ld[4] !== '-' && $ld[4] !== '') continue;
  if (!preg_match('/^\d*\.?\d*$/', $ld[5]) && $ld[5] !== '-' && $ld[5] !== '') continue;
  if (!preg_match('/^\d*\.?\d*$/', $ld[6]) && $ld[6] !== '-' && $ld[6] !== '') continue;

  // Parse the date from the file and format it properly
  $date = DateTime::createFromFormat('d.m.y', $ld[0]);
  $date = $date !== false ? $date->format('d.m.y') : date("d.m.y", strtotime($ld[0], 0));
  // Extract other fields from the file
  $time = $ld[1];
  $duration = $ld[2];
  $location = 0; // Placeholder, needs proper handling
  $quality = $ld[4];
  $interest = $ld[5];
  $method = $ld[6] > 0 ? $ld[6] : 0;
  $text = isset($ld[7]) ? trim(htmlspecialchars($ld[7], ENT_QUOTES | ENT_HTML5, 'UTF-8')) : '';

  // Check for duplicates in the database to avoid inserting the same record
  $duplicateCheckQuery = "SELECT COUNT(*) AS count FROM `ld` WHERE `date` = '$date' AND `time` = '$time' AND `duration` = '$duration' AND `quality` = '$quality' AND `interest` = '$interest' AND `method` = '$method' AND `text` = '$text' AND `user` = '$user'";
  $duplicateCheckResult = mysqli_query($connect, $duplicateCheckQuery);
  $duplicateCount = mysqli_fetch_assoc($duplicateCheckResult)['count'];

  if ($duplicateCount > 0) {
    // Skip this record if it's a duplicate
    continue;
  }

  // Sanitize and insert the new record into the 'ld' table
  $notice = isset($ld[11]) ? trim(htmlspecialchars($ld[11], ENT_QUOTES | ENT_HTML5, 'UTF-8')) : '';
  $setNewLd = mysqli_query($connect, "INSERT INTO `ld` (`date`, `time`, `duration`, `location`, `quality`, `interest`, `method`, `text`, `notice`, `user`, `views`, `likes`) VALUES ('$date', '$time', '$duration', '$location', '$quality', '$interest', '$method', '$text', '$notice', '$user', '[]', '[]')");

  // Retrieve the user's 'ldlist' to update with the new 'ld' ID
  $result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
  $resultldlist = mysqli_fetch_assoc($result);

  $json = $resultldlist['ldlist'] ?? '';
  $ldlist = json_decode($json ?: '[]', true) ?: [];

  // Get the latest 'ld' ID and add it to the user's 'ldlist'
  $result = mysqli_query($connect, "SELECT `id` FROM `ld` ORDER BY id DESC LIMIT 1;");
  $ldlast = mysqli_fetch_assoc($result);
  $ldlist[] = $ldlast['id'];

  // Encode the updated list as JSON and update the user's record
  $ldListNew = json_encode($ldlist);
  $setNewLdInUser = mysqli_query($connect, "UPDATE `user` SET `ldlist` = '$ldListNew' WHERE `id` = '$user'");
}

// Redirect to the home page after processing
header("location:/");
exit();
