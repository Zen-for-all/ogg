<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 * @var array $сhatList List of chat identifiers to process.
 */
session_start();
require '../connect.php';
require '../../controller/setting.php';

// Ensure the user is logged in
if (!isset($_SESSION['userId'])) {
  header("Location: /login");
  exit();
}

// Get the user ID from the session
$id = intval($_SESSION['userId']); // Ensure the user ID is an integer

// Define fields to update with corresponding database columns
$fieldsToUpdate = [
  'gender' => 'gender',
  'birth_year' => 'birth_year',
  'city' => 'city',
  'experience' => 'experience',
  'ldcount' => 'ldcount',
  'ideology' => 'ideology',
  'description' => 'description'
];

// Process each field update from POST data
foreach ($fieldsToUpdate as $key => $field) {
  if (isset($_POST[$key])) {
    $value = $_POST[$key];

    // Prepare and sanitize data based on field type
    switch ($field) {
      case 'gender':
      case 'city':
      case 'description':
        $value = trim($value);
        $updateQuery = "UPDATE user SET description = ? WHERE id = ?";
        $stmt = $connect->prepare($updateQuery);
        $stmt->bind_param('si', $value, $id);
        break;

      case 'birth_year':
      case 'experience':
      case 'ldcount':
      case 'ideology':
        $value = intval($value); // Ensure integer value
        $updateQuery = "UPDATE `user` SET `$field` = ? WHERE `id` = ?";
        $stmt = $connect->prepare($updateQuery);
        $stmt->bind_param('ii', $value, $id);
        break;
    }

    // Execute the prepared statement
    if (isset($stmt)) {
      $stmt->execute();
    }
  }
}

// Collect selected mission IDs from POST data
$selectedMissions = [];
foreach ($_POST as $key => $value) {
  if (strpos($key, 'mission_') === 0) { // Only process keys starting with "mission_"
    $missionId = intval(str_replace('mission_', '', $key)); // Extract mission ID
    if ($missionId > 0) {
      $selectedMissions[] = $missionId;
    }
  }
}

// Update user's mission field with selected mission IDs
$missionsJson = json_encode($selectedMissions);
$updateQuery = "UPDATE `user` SET `mission` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery);
$stmt->bind_param('si', $missionsJson, $id);
$stmt->execute();

// Collect chat values from POST data based on the chat list
$chatArray = [];
foreach ($сhatList as $chat) {
  $chatValue = $_POST[$chat] ?? null;
  if ($chatValue !== null) {
    $chatArray[$chat] = $chatValue; // Add to chat array
  }
}

// Update user's contact field with chat values
$chatsJson = json_encode($chatArray, JSON_UNESCAPED_UNICODE);
$updateQuery = "UPDATE `user` SET `contact` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery);
$stmt->bind_param('si', $chatsJson, $id);
$stmt->execute();

// Redirect the user to the settings page
header("Location: /settings-net");
exit();
