<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */

session_start();
require '../connect.php';

// Get user ID from session
$user = $_SESSION['userId'];

// Get parameters from the POST request
$id = $_POST['id'];
$date = date("d.m.y", strtotime($_POST['date']));
$time = $_POST['time'];
$duration = $_POST['duration'];
$location = $_POST['location'];
$quality = $_POST['quality'];
$interest = $_POST['interest'];
$method = $_POST['method'];
$text = trim(htmlentities($_POST['text']));
$notice = trim(htmlentities($_POST['notice']));

// Handle hashtags, filter empty values and encode them as JSON
$hashtags = array_filter([
  trim(htmlentities($_POST['tag_1'])),
  trim(htmlentities($_POST['tag_2'])),
  trim(htmlentities($_POST['tag_3'])),
  trim(htmlentities($_POST['tag_4']))
]);

$jsonHashtags = json_encode($hashtags, JSON_UNESCAPED_UNICODE);  // Encode hashtags to JSON format

$public_text = trim(htmlentities($_POST['public_text']));  // Clean and trim public text input

// Check if 'publish' is set and equals 'on', otherwise set to 0
$publish = isset($_POST['publish']) && $_POST['publish'] === 'on' ? 1 : 0;

// Check if a record with the provided ID already exists
$checkExistingRecord = mysqli_query($connect, "SELECT * FROM `ld` WHERE `id` = '$id'");

if (mysqli_num_rows($checkExistingRecord) > 0) {
  // If record exists, update it with new data
  $updateRecord = mysqli_query($connect, "UPDATE `ld` SET
        `date` = '$date',
        `time` = '$time',
        `duration` = '$duration',
        `location` = '$location',
        `quality` = '$quality',
        `interest` = '$interest',
        `method` = '$method',
        `text` = '$text',
        `notice` = '$notice',
        `hashtags` = '$jsonHashtags',
        `public_text` = '$public_text',
        `publish` = '$publish',
        `user` = '$user'
        WHERE `id` = '$id'");
}

// Redirect to the updated page after the operation
header("Location:/?page=ld&id=" . $id);
exit();
