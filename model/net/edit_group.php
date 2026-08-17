<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 * @var array $missionList An array of missions associated with the group.
 * @var array $сhatList An array of chat groups associated with the group.
 */
?>

<?php
session_start();

// Include necessary files
require '../connect.php';
require '../../controller/setting.php';

// Retrieve form data
$id = $_POST['id'];
$title = $_POST['title'];
$text = $_POST['text'];
$groupId = intval($_POST['id']);
$uploadDir = __DIR__ . '/../../view/uploads/group_avatars/';

/*
// Check if the avatar is being deleted
if (isset($_POST['delete_avatar'])) {
  // Get the current avatar file path from the database
  $query = "SELECT `avatar` FROM `group` WHERE `id` = ?";
  $stmt = $connect->prepare($query);
  $stmt->bind_param('i', $groupId);
  $stmt->execute();
  $stmt->bind_result($currentAvatar);
  $stmt->fetch();
  $stmt->close();

  // Delete the physical file if it exists
  if ($currentAvatar) {
    $avatarFilePath = $uploadDir . basename($currentAvatar);
    if (file_exists($avatarFilePath)) {
      unlink($avatarFilePath); // Delete the avatar file
    }
  }

  // Set avatar field to NULL in the database
  $updateQuery = "UPDATE `group` SET `avatar` = NULL WHERE `id` = ?";
  $stmt = $connect->prepare($updateQuery);
  $stmt->bind_param('i', $groupId);
  $stmt->execute();

  echo 'Avatar deleted successfully.';
  header("Location: /?page=group&id=$groupId");
  exit();
}*/

// Check if the file was uploaded
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
  // Get the file extension
  $fileExtension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

  // Generate the filename with 'ava_' prefix and group ID
  $fileName = 'ava_' . $groupId . '.' . $fileExtension;
  $targetFile = $uploadDir . $fileName;

  // Check the file type
  $fileType = mime_content_type($_FILES['avatar']['tmp_name']);
  if (strpos($fileType, 'image') === 0) {
    // Get the image dimensions
    list($width, $height) = getimagesize($_FILES['avatar']['tmp_name']);

    // Define the maximum width or height
    $maxSize = 800;

    // Resize the image if necessary
    if ($width > $maxSize || $height > $maxSize) {
      // Calculate the scaling factor
      if ($width > $height) {
        $newWidth = $maxSize;
        $newHeight = (int)($height * $maxSize / $width);
      } else {
        $newHeight = $maxSize;
        $newWidth = (int)($width * $maxSize / $height);
      }

      // Create a new image resource for the resized image
      $image = null;
      switch ($fileExtension) {
        case 'jpeg':
        case 'jpg':
          $image = imagecreatefromjpeg($_FILES['avatar']['tmp_name']);
          break;
        case 'png':
          $image = imagecreatefrompng($_FILES['avatar']['tmp_name']);
          break;
        case 'gif':
          $image = imagecreatefromgif($_FILES['avatar']['tmp_name']);
          break;
        default:
          echo 'Unsupported image type.';
          exit();
      }

      // Create a new true color image with the resized dimensions
      $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

      // Resample the image to the new dimensions
      imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

      // Save the resized image to the target file
      switch ($fileExtension) {
        case 'jpeg':
        case 'jpg':
          imagejpeg($resizedImage, $targetFile);
          break;
        case 'png':
          imagepng($resizedImage, $targetFile);
          break;
        case 'gif':
          imagegif($resizedImage, $targetFile);
          break;
      }

      // Free up memory
      imagedestroy($image);
      imagedestroy($resizedImage);
    } else {
      // If the image does not need resizing, move the file directly
      move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile);
    }

    // Prepare the SQL query to update the avatar URL in the database
    $avatarUrl = '/view/uploads/group_avatars/' . $fileName;

    // Prepare the SQL query to update the avatar in the database
    $updateQuery = "UPDATE `group` SET `avatar` = ? WHERE `id` = ?";
    $stmt = $connect->prepare($updateQuery); // Prepare the query for execution
    $stmt->bind_param('si', $avatarUrl, $groupId); // Bind the parameters: 's' for string (avatar URL), 'i' for integer (group ID)
    $stmt->execute(); // Execute the prepared statement

    echo 'File uploaded and avatar updated successfully.';
  } else {
    echo 'The file must be an image.';
  }
}

// Prepare missions array (only missions with a selected value)
$mission_array = [];
foreach ($missionList as $key => $mission) {
  // Check if the mission value is not null or false
  $mission_value = $_POST['mission_edit_' . $key] ?? null;
  if ($mission_value !== null && $mission_value !== false) {
    $mission_array[] = $key; // Add mission key to the array
  }
}
$mission = json_encode($mission_array); // Encode the mission array as JSON

// Prepare chats array (store the chat group values from the form)
$chat_array = [];
foreach ($сhatList as $key => $chat) {
  $chat_array[$chat] = $_POST[$chat]; // Assign form values to chat keys
}
$chats = json_encode($chat_array, JSON_UNESCAPED_UNICODE); // Encode chat array as JSON

//Add City name
$city = $_POST['group_city'];

// Check if a record with the given group ID exists
$checkExistingRecord = mysqli_query($connect, "SELECT * FROM `group` WHERE `id` = '$id'");

if (mysqli_num_rows($checkExistingRecord) > 0) {
  // If a record exists, update the group information
  $updateRecord = mysqli_query($connect, "UPDATE `group` SET
        `title` = '$title',
        `text` = '$text',
        `mission` = '$mission',
        `chats` = '$chats',
        `city` = '$city'
        WHERE `id` = '$id'");
}

// Redirect to the group page after updating
header("Location: /?page=group&id=" . $id);
exit();
