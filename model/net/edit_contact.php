<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 * @var array $сhatList
 */
?>

<?php
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

// Initialize an empty array to store chat values
$chat_array = [];

// Loop through the chat list and retrieve the POST data
foreach ($сhatList as $chat) {
  // Get the value for each chat, or set it as null if not set
  $chat_value = $_POST[$chat] ?? null;
  if ($chat_value !== null) {
    // Store the chat value in the array
    $chat_array[$chat] = $chat_value;
  }
}

// Convert the chat array to a JSON string
$chats_json = json_encode($chat_array, JSON_UNESCAPED_UNICODE);

// Prepare the SQL query to update the user's contact field
$updateQuery = "UPDATE `user` SET `contact` = ? WHERE `id` = ?";
$stmt = $connect->prepare($updateQuery); // Prepare the query for execution
$stmt->bind_param('si', $chats_json, $id); // Bind the parameters: 's' for string (JSON), 'i' for integer (user ID)
$stmt->execute(); // Execute the prepared statement

// Redirect the user back to the settings page after the update
header("Location: /settings-net");
exit();
