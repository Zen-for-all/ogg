<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 * @var array $groupMissions List of available missions for the group.
 * @var array $groupChat List of available chat groups for the group.
 */
?>

<?php
session_start();
require '../connect.php';
require '../../controller/setting.php';

// Get the user ID from the session and the post data
$user = $_SESSION['userId'];
$title = $_POST['title'] ?? ''; // Default to empty string if title is not set
$text = $_POST['text'] ?? ''; // Default to empty string if text is not set

// Add Missions to an array, only if selected by the user
$mission_array = [];
foreach ($groupMissions as $key => $mission) {
  $mission_value = $_POST['mission_' . $key] ?? null; // Get the mission value or null
  if ($mission_value !== null && $mission_value !== false) {
    $mission_array[] = $key; // Add the mission key if it is selected
  }
}
$mission = json_encode($mission_array); // Encode the mission array to JSON

// Add Users to an array (just the current user for now)
$user_array = [$user]; // Simplified initialization
$users = json_encode($user_array); // Encode the users array to JSON

// Add Chat settings to an array
$chat_array = [];
foreach ($groupChat as $key => $chat) {
  $chat_value = $_POST[$chat] ?? null; // Get the chat value or null
  if ($chat_value !== null) {
    $chat_array[$chat] = $chat_value; // Store chat value
  }
}
$chats = json_encode($chat_array, JSON_UNESCAPED_UNICODE); // Encode chat array to JSON

// Add current date in d.m.y format
$datePublic = date("d.m.y");

// The private field is not implemented yet, it is set to 0 (not private)
$private = 0;

// If the title is not empty, insert the new group into the database
if ($title !== '') {
  // Insert the new group into the database
  $setNewGroup = mysqli_query($connect, "
    INSERT INTO `groups` (`title`, `text`, `mission`, `admin`, `users`, `chats`, `date`, `private`) 
    VALUES ('$title', '$text', '$mission', '$user', '$users', '$chats', '$datePublic', '$private')
  ");

  // Get user info and group list from the database
  $result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
  $resultgrouplist = mysqli_fetch_assoc($result);
  $grouplist = json_decode($resultgrouplist['grouplist'], true); // Decode the user's group list from JSON

  // Get the ID of the last inserted group
  $result = mysqli_query($connect, "SELECT `id` FROM `groups` ORDER BY id DESC LIMIT 1;");
  $grouplast = mysqli_fetch_assoc($result);

  // Update the user's group list by adding the new group ID
  $groupnew = $grouplist ?? []; // If the group list is empty, initialize as an empty array
  $groupnew[] = $grouplast['id']; // Add the new group ID to the list
  $groupnew_json = json_encode($groupnew); // Encode the updated list as JSON

  // Update the user's group list in the database
  $setNewGroupInUser = mysqli_query($connect, "UPDATE `user` SET `grouplist` = '$groupnew_json' WHERE `id` = '$user'");
}

// Redirect to the groups page after the operation
header("Location: /groups");
exit();
