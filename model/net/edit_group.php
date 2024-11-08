<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 * @var array $groupMissions An array of missions associated with the group.
 * @var array $groupChat An array of chat groups associated with the group.
 */
?>

<?php
session_start();

// Include necessary files
require '../connect.php';
require '../../controller/setting.php';

// Retrieve form data
$id = $_POST['id'];
$title = $_POST['title'];
$text = $_POST['text'];

// Prepare missions array (only missions with a selected value)
$mission_array = [];
foreach ($groupMissions as $key => $mission) {
  // Check if the mission value is not null or false
  $mission_value = $_POST['mission_' . $key] ?? null;
  if ($mission_value !== null && $mission_value !== false) {
    $mission_array[] = $key; // Add mission key to the array
  }
}
$mission = json_encode($mission_array); // Encode the mission array as JSON

// Prepare chats array (store the chat group values from the form)
$chat_array = [];
foreach ($groupChat as $key => $chat) {
  $chat_array[$chat] = $_POST[$chat]; // Assign form values to chat keys
}
$chats = json_encode($chat_array, JSON_UNESCAPED_UNICODE); // Encode chat array as JSON

// Check if a record with the given group ID exists
$checkExistingRecord = mysqli_query($connect, "SELECT * FROM `groups` WHERE `id` = '$id'");

if (mysqli_num_rows($checkExistingRecord) > 0) {
  // If a record exists, update the group information
  $updateRecord = mysqli_query($connect, "UPDATE `groups` SET
        `title` = '$title',
        `text` = '$text',
        `mission` = '$mission',
        `chats` = '$chats'
        WHERE `id` = '$id'");
}

// Redirect to the group page after updating
header("Location: /?page=group&id=" . $id);
exit();
