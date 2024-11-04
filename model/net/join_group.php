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
$userIdArray[] = $userId;
$jsonUserIdArray = json_encode($userIdArray);

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

// add new group ID if not already in the list
if (!in_array($groupId, $groupList)) {
  $groupList[] = $groupId;
}

$groupNewJson = json_encode($groupList); // encode updated group list to JSON

// update group list in user info
$setNewLdInUser = mysqli_query($connect, "UPDATE `user` SET `grouplist` = '$groupNewJson' WHERE `id` = '$userId'");

header("location:/?page=group&id=" . $groupId);