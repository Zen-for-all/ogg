<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';
require '../../controller/class/Group.php';

// Sanitize and cast input values
$userId = (int)$_SESSION['userId'];
$groupId = $_POST['group_id'];

// Initialize Group object and get existing users
$group = new Group($groupId);
$userIdArray = json_decode($group->users, true);  // Decode group users list from JSON
$userIdArray[] = $userId;  // Add the new user ID to the group users list
$jsonUserIdArray = json_encode($userIdArray);  // Re-encode users list to JSON

// Update the Group's user list in the database
$updateGroupQuery = "UPDATE `groups` SET `users` = '$jsonUserIdArray' WHERE `id` = '$groupId'";
mysqli_query($connect, $updateGroupQuery);

// Update User's group list
// Get current user's group list
$result = mysqli_query($connect, "SELECT `grouplist` FROM `user` WHERE `id` = '$userId'");
$userData = mysqli_fetch_assoc($result);

// Initialize user's group list, decode from JSON or start with an empty array
$groupList = json_decode($userData['grouplist'] ?? '[]', true);

// Add the new group ID if it's not already in the list
if (!in_array($groupId, $groupList)) {
  $groupList[] = $groupId;
}

$groupNewJson = json_encode($groupList);  // Encode updated group list to JSON

// Update the user's group list in the database
$setNewGroupInUserQuery = "UPDATE `user` SET `grouplist` = '$groupNewJson' WHERE `id` = '$userId'";
mysqli_query($connect, $setNewGroupInUserQuery);

// Redirect to the group page
header("Location: /?page=group&id=" . $groupId);
exit();
