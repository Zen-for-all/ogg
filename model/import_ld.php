<?php
session_start();
require 'connect.php';

mysqli_set_charset($connect, "utf8mb4");

$user = $_SESSION['userid'];

$array_ld = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["upload_txt"])) {
  // Check if the file was uploaded without errors
  if (isset($_FILES["txt_file"]) && $_FILES["txt_file"]["error"] == UPLOAD_ERR_OK) {
    // Get the content of the file
    $txt_content = file_get_contents($_FILES["txt_file"]["tmp_name"]);

    // Original string of the text file with tab delimiter
    $txtString = $txt_content;

    // Delimiter, now it's tab
    $delimiter = "\t";

    // Prepare a temporary file and write the text string to it
    $tempFile = tempnam(sys_get_temp_dir(), 'txt_temp');
    file_put_contents($tempFile, $txtString);

    // Open the temporary file and read the data with tab delimiter
    $handle = fopen($tempFile, "r");
    $array_ld = [];
    if ($handle) {
      while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
        // Data processing, for example, adding to an array
        $array_ld[] = $data;
      }
      fclose($handle);
    }

    // Delete the temporary file
    unlink($tempFile);
  } else {
    echo "Error uploading file.";
  }
}

foreach ($array_ld as $ld) {
  // Validate input data
  if (!preg_match('/^\d*\.?\d*$/', $ld[2]) && $ld[2] !== '-' && $ld[2] !== '') continue;
  if (!preg_match('/^\d*\.?\d*$/', $ld[4]) && $ld[4] !== '-' && $ld[4] !== '') continue;
  if (!preg_match('/^\d*\.?\d*$/', $ld[5]) && $ld[5] !== '-' && $ld[5] !== '') continue;
  if (!preg_match('/^\d*\.?\d*$/', $ld[6]) && $ld[6] !== '-' && $ld[6] !== '') continue;

  // get $_POST params
  $date = DateTime::createFromFormat('d.m.y', $ld[0]);

  if ($date !== false) {
    $date = $date->format('d.m.y');
  } else {
    $date = date("d.m.y", strtotime($ld[0],0));
  }

  $time = $ld[1];
  $duration = $ld[2];
  $location = 0; // need fix
  $quality = $ld[4];
  $interest = $ld[5];

  if ($ld[6] > 0) {
    $method = $ld[6];
  } else {
    $method = 0;
  }

  $text = trim(htmlspecialchars($ld[7], ENT_QUOTES | ENT_HTML5, 'UTF-8'));

  // Check for duplicates in the database
  $duplicateCheckQuery = "SELECT COUNT(*) AS count FROM `ld` WHERE `date` = '$date' AND `time` = '$time' AND `duration` = '$duration' AND `quality` = '$quality' AND `interest` = '$interest' AND `method` = '$method' AND `text` = '$text'";
  $duplicateCheckResult = mysqli_query($connect, $duplicateCheckQuery);
  $duplicateCount = mysqli_fetch_assoc($duplicateCheckResult)['count'];

  if ($duplicateCount > 0) {
    // Skip this record as it's a duplicate
    continue;
  }

  $notice = trim(htmlspecialchars($ld[8], ENT_QUOTES | ENT_HTML5, 'UTF-8'));

  // add new ld
  $setNewLd = mysqli_query($connect, "INSERT INTO `ld` (`date`, `time`, `duration`, `location`, `quality`, `interest`, `method`, `text`, `notice`, `user`) VALUES ('$date', '$time', '$duration', '$location', '$quality', '$interest', '$method', '$text', '$notice', '$user')");

  // get all user info from id
  $result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
  $resultldlist = mysqli_fetch_assoc($result);
  $ldlist = json_decode($resultldlist['ldlist'], true);

  if (!is_array($ldlist)) {
    $ldlist = [];
  }

  // get & edit ld list
  $result = mysqli_query($connect, "SELECT `id` FROM `ld` ORDER BY id DESC LIMIT 1;");
  $ldlast = mysqli_fetch_assoc($result);
  $ldlist[] = $ldlast['id'];

  $ldListNew = json_encode($ldlist);

  // update ld list in user info
  $setNewLdInUser = mysqli_query($connect, "UPDATE `user` SET `ldlist` = '$ldListNew' WHERE `id` = '$user'");
}

header("location:/");