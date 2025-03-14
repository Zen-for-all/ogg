<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */

session_start();
require '../connect.php';
require '../../controller/class/Ld.php';

// Get parameters from the POST request
$user_id = (int) $_POST['user_id'];
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
if ($id <= 0) {
  header("Location:/");
  exit();
}

$ld = new Ld($id);
$likes = $ld->likes;

// Ensure $likes is a valid array
if (is_string($likes) && !empty($likes)) {
  $likes = json_decode($likes, true);
}
if (!is_array($likes)) {
  $likes = [];
}

// Toggle like
if (!in_array($user_id, $likes, true)) {
  $likes[] = $user_id;
} else {
  $key = array_search($user_id, $likes, true);
  if ($key !== false) {
    unset($likes[$key]);
    $likes = array_values($likes);
  }
}

// Encode likes back to JSON format
$new_likes = json_encode($likes, JSON_UNESCAPED_UNICODE);

// Update the database record
$query = "UPDATE `ld` SET `likes` = ? WHERE `id` = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "si", $new_likes, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Redirect to the updated page after the operation
header("Location:/?page=post&id=" . $id);
exit();
