<?php
/**
 * @var $connect
 */
?>

<?php
session_start();
require '../connect.php';
require '../../controller/class/Group.php';

$userId = (int) $_POST['user_id'];
$groupId = $_POST['group_id'];

// get all info about group
$group = new Group($groupId);
$userIdArray = json_decode($group->users, true);

if (count($userIdArray) < 2) {
  $deletegroup = mysqli_query($connect, "DELETE FROM `groups` WHERE `id` = '$groupId'");
} else {
  $userIdArray = array_diff($userIdArray, [$userId]);
  $jsonUserIdArray = json_encode($userIdArray);
}

// update Group
$updateGroup = mysqli_query($connect, "UPDATE `groups` SET
      `users` = '$jsonUserIdArray'
      WHERE `id` = '$groupId'");

// update User
// get only the 'grouplist' column for the specified user ID
$result = mysqli_query($connect, "SELECT `grouplist` FROM `user` WHERE `id` = '$userId'");
$userData = mysqli_fetch_assoc($result);

// initialize group list, decode JSON if exists, or start with empty array
$groupList = json_decode($userData['grouplist'] ?? '[]', true);

// Search for the group and remove it if found
$key = array_search($groupId, $groupList, true);

if ($key !== false) {
  array_splice($groupList, $key, 1); // Remove the group from the array
}

$groupNewJson = json_encode($groupList); // encode updated group list to JSON

// update group list in user info
$setNewLdInUser = mysqli_query($connect, "UPDATE `user` SET `grouplist` = '$groupNewJson' WHERE `id` = '$userId'");

if (count($userIdArray) < 2) {
  header("location:/groups");
} else {
  header("location:/?page=group&id=" . $groupId);
}