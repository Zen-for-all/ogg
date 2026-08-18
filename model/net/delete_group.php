<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */

session_start();
require '../connect.php';
require '../../controller/class/Group.php';

$userId = (int)$_SESSION['userId'];

// Create a Group object using the 'delete' parameter from the POST request
$group = new Group($_SESSION['group_id']);

if ($group->admin == $userId) { // If admin
  // If the avatar exists, delete the physical avatar file
  if ($group->avatar) {
    $avatarFilePath = $_SERVER['DOCUMENT_ROOT'] . '/view/uploads/group_avatars/' . basename($group->avatar);
    if (file_exists($avatarFilePath)) {
      unlink($avatarFilePath); // Delete the avatar file
    }
  }

  $users = json_decode($group->users, true); // Decode the JSON string into an array of user IDs

  // Delete the group from the 'groups' table based on the group ID
  $deletegroup = mysqli_query($connect, "DELETE FROM `group` WHERE `id` = '$group->id'");

  // Loop through each user and remove the group from their 'grouplist'
  foreach ($users as $userId) {
    // Get the current user's data from the 'user' table
    $result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$userId'");
    $resultgrouplist = mysqli_fetch_assoc($result);
    $grouplist = json_decode($resultgrouplist['grouplist'], true); // Decode the user's 'grouplist'

    // If 'grouplist' is not an array (in case of unexpected data), initialize it as an empty array
    if (!is_array($grouplist)) {
      $grouplist = [];
    }

    // Search for the group to be deleted within the user's 'grouplist'
    $key = array_search($group->id, $grouplist, true);
    if ($key !== false) {
      // If the group is found, remove it from the array
      array_splice($grouplist, $key, 1);
    }

    // Convert the updated 'grouplist' array back to a JSON string and update the user record
    $groupNew = json_encode($grouplist);
    mysqli_query($connect, "UPDATE `user` SET `grouplist` = '$groupNew' WHERE `id` = '$userId'");
  }
}

// Redirect to the groups page after processing
header("location:/?page=groups");
exit();
