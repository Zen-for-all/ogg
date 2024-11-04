<?php
session_start();
require '../connect.php';
require '../../controller/class/Group.php';

$group = new Group($_POST['delete']);
$users = json_decode($group->users, true); // Decode the JSON string into an array

$deletegroup = mysqli_query($connect, "DELETE FROM `groups` WHERE `id` = '$group->id'");

foreach ($users as $userId) {
  // Get the group list of the current user
  $result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$userId'");
  $resultgrouplist = mysqli_fetch_assoc($result);
  $grouplist = json_decode($resultgrouplist['grouplist'], true);

  // Check if $grouplist is an array
  if (!is_array($grouplist)) {
    $grouplist = [];
  }

  // Search for the group and remove it if found
  $key = array_search($_POST['delete'], $grouplist, true);
  if ($key !== false) {
    array_splice($grouplist, $key, 1); // Remove the group from the array
  }

  // Update the `grouplist` field for the current user
  $groupNew = json_encode($grouplist);
  mysqli_query($connect, "UPDATE `user` SET `grouplist` = '$groupNew' WHERE `id` = '$userId'");
}

header("location:/?page=groups");