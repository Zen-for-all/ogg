<?php
session_start();
require 'connect.php';

$array_ld = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["upload_txt"])) {
  // Check if the file was uploaded without errors
  if (isset($_FILES["txt_file"]) && $_FILES["txt_file"]["error"] == UPLOAD_ERR_OK) {
    // Get the content of the file
    $txt_content = file_get_contents($_FILES["txt_file"]["tmp_name"]);
    $txt_content = mb_convert_encoding($txt_content, 'UTF-8', 'Windows-1251');

    // Original string of the text file with tab delimiter
    $txtString = $txt_content; // Insert your string here

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
  // get $_POST params
  $date = date("d.m.y", strtotime($ld[0]));
  $time = $ld[1];
  $duration = 0;
  $duration = $ld[2];
  $text = trim(htmlentities($ld[3]));
  $quality = $ld[4];
  $interest = $ld[5];
  $notice = trim(htmlentities($ld[6]));
  $user = $_SESSION['userid'];
  $location = 0;
  $method = 0;

  // add new ld
  $setNewLd = mysqli_query($connect, "INSERT INTO `ld` (`date`, `time`, `duration`, `location`, `quality`, `interest`, `method`, `text`, `notice`, `user`) VALUES ('$date', '$time', '$duration', '$location', '$quality', '$interest', '$method', '$text', '$notice', '$user')");

  // get all user info from id
  $result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
  $resultldlist = mysqli_fetch_assoc($result);
  $ldlist = $resultldlist['ldlist'];

  // get & edit ld list
  $result = mysqli_query($connect, "SELECT `id` FROM `ld` ORDER BY id DESC LIMIT 1;");
  $ldlast = mysqli_fetch_assoc($result);
  $ldnew = $ldlist . ' ' . $ldlast['id'];

  // update ld list in user info
  $setNewLdInUser = mysqli_query($connect, "UPDATE `user` SET `ldlist` = '$ldnew' WHERE `id` = '$user'");
}

header("location:/?page=journal");
?>