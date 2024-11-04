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

$id = $_POST['id'];
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

// add Chats
$chat_array = [];
foreach ($groupChat as $key => $chat) {
  $chat_array[$chat] = $_POST[$chat];
}
$chats = json_encode($chat_array, JSON_UNESCAPED_UNICODE);

// update Group
$checkExistingRecord = mysqli_query($connect, "SELECT * FROM `groups` WHERE `id` = '$id'");

if (mysqli_num_rows($checkExistingRecord) > 0) {
  $updateRecord = mysqli_query($connect, "UPDATE `groups` SET
        `title` = '$title',
        `text` = '$text',
        `mission` = '$mission',
        `chats` = '$chats'
        WHERE `id` = '$id'");
}

header("location:/?page=group&id=" . $id);