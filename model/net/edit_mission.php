<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
session_start();
require '../connect.php';

// Ensure the user is logged in
if (!isset($_SESSION['userId'])) {
  header("Location: /login");
  exit();
}

// Get the user ID from the session
$id = intval($_SESSION['userId']); // Ensure the user ID is an integer

// Initialize an array to hold the selected mission IDs
$selectedMissions = [];

// Loop through all posted checkboxes and collect the selected mission IDs
foreach ($_POST as $key => $value) {
  if (strpos($key, 'mission_') === 0) { // Only process keys starting with "mission_"
    $missionId = intval(str_replace('mission_', '', $key)); // Get the mission ID from the checkbox name
    if ($missionId > 0) { // Ensure the mission ID is valid
      $selectedMissions[] = $missionId;
    }
  }
}

// Convert the selected missions array into a JSON string
$missionsJson = json_encode($selectedMissions);

// Prepare the SQL query to update the user's mission field
$updateQuery = "UPDATE `user` SET `mission` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery); // Prepare the query for execution
$stmt->bind_param('si', $missionsJson, $id); // Bind the parameters: 's' for string (missions JSON), 'i' for integer (user ID)
$stmt->execute(); // Execute the prepared statement

// Redirect the user back to the settings page after the update
header("Location: /settings-net");
exit();
