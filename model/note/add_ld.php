<?php
/**
 * @var $connect
 */
?>

<?php
session_start();
require '../connect.php';

$user = $_SESSION['userid'];
// get $_POST parameters
$date = date("d.m.y", strtotime($_POST['date']));
$time = $_POST['time'];
$duration = $_POST['duration'];
$location = $_POST['location'];
$quality = $_POST['quality'];
$interest = $_POST['interest'];
$method = $_POST['method'];
$text = trim(htmlentities($_POST['text']));
$notice = trim(htmlentities($_POST['notice']));

$hashtags = array_filter([
  trim(htmlentities($_POST['tag_1'])),
  trim(htmlentities($_POST['tag_2'])),
  trim(htmlentities($_POST['tag_3'])),
  trim(htmlentities($_POST['tag_4']))
]);
$jsonHashtags = json_encode($hashtags, JSON_UNESCAPED_UNICODE);

$public_text = trim(htmlentities($_POST['public_text']));

if (isset($_POST['publish']) && $_POST['publish'] === 'on') {
  $publish = 1;
} else {
  $publish = 0;
}

// add new learning and development entry
$setNewLd = mysqli_query($connect, "INSERT INTO `ld` (`date`, `time`, `duration`, `location`, `quality`, `interest`, `method`, `text`, `hashtags`, `public_text`, `publish`, `notice`, `user`) VALUES ('$date', '$time', '$duration', '$location', '$quality', '$interest', '$method', '$text', '$jsonHashtags', '$public_text', '$publish', '$notice', '$user')");

// get all user info from user ID
$result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
$resultldlist = mysqli_fetch_assoc($result);
$ldlist = json_decode($resultldlist['ldlist'], true); // decode JSON into PHP array

// get the last inserted learning and development entry ID
$result = mysqli_query($connect, "SELECT `id` FROM `ld` ORDER BY id DESC LIMIT 1;");
$ldlast = mysqli_fetch_assoc($result);
$ldnew = $ldlist; // initialize new array for update

if (!empty($ldlist)) {
  $ldnew[] = $ldlast['id']; // add new ID to array
} else {
  $ldnew = [$ldlast['id']]; // if array is empty, create new array with one element
}

$ldnew_json = json_encode($ldnew); // encode array into JSON format

// update learning and development list in user info
$setNewLdInUser = mysqli_query($connect, "UPDATE `user` SET `ldlist` = '$ldnew_json' WHERE `id` = '$user'");

header("location:/?page=journal");