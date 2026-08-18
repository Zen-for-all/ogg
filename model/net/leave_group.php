<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */

session_start();
require '../connect.php';
require '../../controller/class/Group.php';

// Sanitize and retrieve POST data
$userId = $_POST['user_id'];
$groupId = $_POST['group_id'];

// Create a new instance of the Group class to get group data
$group = new Group($groupId);

// Decode the 'users' JSON field from the group to get an array of user IDs
$userIdArray = json_decode($group->users, true);

// If the group has only 1 user, delete the group
if (count($userIdArray) === 1) {
  $deletegroup = mysqli_query($connect, "DELETE FROM `group` WHERE `id` = '$groupId'");
} else {
  // Remove the current user from the group if there are multiple users
  $userIdArray = array_diff($userIdArray, [$userId]);
  $jsonuserIdArray = json_encode($userIdArray); // Encode the updated user list to JSON
}

// Update the group with the new user list
$updateGroup = mysqli_query($connect, "UPDATE `group` SET
      `users` = '$jsonuserIdArray'
      WHERE `id` = '$groupId'");

// Retrieve the user's current group list
$result = mysqli_query($connect, "SELECT `grouplist` FROM `user` WHERE `id` = '$userId'");
$userData = mysqli_fetch_assoc($result);

// Decode the user's current group list or start with an empty array if it's null
$groupList = json_decode($userData['grouplist'] ?? '[]', true);

// Search for the group ID in the user's group list and remove it
$key = array_search($groupId, $groupList, true);
if ($key !== false) {
  array_splice($groupList, $key, 1); // Remove the group from the list
}

// Encode the updated group list into JSON
$groupNewJson = json_encode($groupList);

// Update the user's group list in the database
$setNewLdInUser = mysqli_query($connect, "UPDATE `user` SET `grouplist` = '$groupNewJson' WHERE `id` = '$userId'");

header("location:/?page=group&id=" . $groupId);

exit();
