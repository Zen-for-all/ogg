<?php
/**
 * @var $connect
 * @var $groupMissions
 * @var $groupChat
 */
?>

<?php
session_start();
require '../connect.php';
require '../../controller/setting.php';

$user = $_SESSION['userId'];
$title = $_POST['title'];
$text = $_POST['text'];

// add Missions
$mission_array = [];
foreach ($groupMissions as $key => $mission) {
  $mission_value = $_POST['mission_' . $key] ?? null;
  if ($mission_value !== null && $mission_value !== false) {
    $mission_array[] = $key;
  }
}
$mission = json_encode($mission_array);

// add Users
$user_array[] = $user;
$users = json_encode($user_array);

// add Chats
$chat_array = [];
foreach ($groupChat as $key => $chat) {
  $chat_array[$chat] = $_POST[$chat];
}
$chats = json_encode($chat_array, JSON_UNESCAPED_UNICODE);

// add Date
$datePublic = date("d.m.y");

// add Private
/* In the future, private groups will be implemented. */

if ($title == '') {
  // If the title is empty, do nothing
} else {
  // Insert new group into the database
  $setNewGroup = mysqli_query($connect, "INSERT INTO `groups` (`title`, `text`, `mission`, `admin`, `users`, `chats`, `date`, `private`) VALUES ('$title', '$text', '$mission', '$user', '$users', '$chats', '$datePublic', '0')");

  // Get all user info from user ID
  $result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
  $resultgrouplist = mysqli_fetch_assoc($result);
  $grouplist = json_decode($resultgrouplist['grouplist'], true); // Decode JSON into PHP array

  // Get the last inserted learning and development entry ID
  $result = mysqli_query($connect, "SELECT `id` FROM `groups` ORDER BY id DESC LIMIT 1;");
  $grouplast = mysqli_fetch_assoc($result);
  $groupnew = $grouplist; // Initialize new array for update

  if (!empty($grouplist)) {
    $groupnew[] = $grouplast['id']; // Add new ID to array
  } else {
    $groupnew = [$grouplast['id']]; // If array is empty, create new array with one element
  }
  $groupnew_json = json_encode($groupnew); // Encode array into JSON format

  // Update learning and development list in user info
  $setNewGroupInUser = mysqli_query($connect, "UPDATE `user` SET `grouplist` = '$groupnew_json' WHERE `id` = '$user'");
}

header("location:/groups");