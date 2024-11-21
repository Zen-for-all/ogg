<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 * @var array $missionList List of available missions for the group.
 * @var array $сhatList List of available chat groups for the group.
 */
?>

<?php
session_start();
require '../connect.php';
require '../../controller/setting.php';

// Get the user ID from the session and the post data
$user = $_SESSION['userId'];
$title = $_POST['title'];
$text = $_POST['text'] ?? ''; // Default to empty string if text is not set
$uploadDir = __DIR__ . '/../../view/uploads/group_avatars/';

// Add Missions to an array, only if selected by the user
$mission_array = [];
foreach ($missionList as $key => $mission) {
  $mission_value = $_POST['mission_' . $key] ?? null; // Get the mission value or null
  if ($mission_value !== null && $mission_value !== false) {
    $mission_array[] = $key; // Add the mission key if it is selected
  }
}
$mission = json_encode($mission_array); // Encode the mission array to JSON

// Add Users to an array (just the current user for now)
$user_array = [$user]; // Simplified initialization
$users = json_encode($user_array); // Encode the users array to JSON

// Add Chat settings to an array
$chat_array = [];
foreach ($сhatList as $key => $chat) {
  $chat_value = $_POST[$chat] ?? null; // Get the chat value or null
  if ($chat_value !== null) {
    $chat_array[$chat] = $chat_value; // Store chat value
  }
}
$chats = json_encode($chat_array, JSON_UNESCAPED_UNICODE); // Encode chat array to JSON

//Add City name
$city = $_POST['group_city'];

// Add current date in d.m.y format
$datePublic = date("d.m.y");

// The private field is not implemented yet, it is set to 0 (not private)
$private = 0;

// If the title is not empty, insert the new group into the database
if ($title !== '') {
  // Insert the new group into the database
  $setNewGroup = mysqli_query($connect, "
    INSERT INTO `groups` (`title`, `text`, `mission`, `admin`, `users`, `chats`, `city`, `date`, `private`) 
    VALUES ('$title', '$text', '$mission', '$user', '$users', '$chats', '$city', '$datePublic', '$private')
  ");

  // Get user info and group list from the database
  $result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
  $resultgrouplist = mysqli_fetch_assoc($result);
  $grouplist = json_decode($resultgrouplist['grouplist'], true); // Decode the user's group list from JSON

  // Get the ID of the last inserted group
  $result = mysqli_query($connect, "SELECT `id` FROM `groups` ORDER BY id DESC LIMIT 1;");
  $grouplast = mysqli_fetch_assoc($result);

  // Update the user's group list by adding the new group ID
  $groupnew = $grouplist ?? []; // If the group list is empty, initialize as an empty array
  $groupnew[] = $grouplast['id']; // Add the new group ID to the list
  $groupnew_json = json_encode($groupnew); // Encode the updated list as JSON

  // Update the user's group list in the database
  $setNewGroupInUser = mysqli_query($connect, "UPDATE `user` SET `grouplist` = '$groupnew_json' WHERE `id` = '$user'");



  // Check if the file was uploaded
  if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $groupId = $grouplast['id'];

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
      $updateQuery = "UPDATE `groups` SET `avatar` = ? WHERE `id` = ?";
      $stmt = $connect->prepare($updateQuery); // Prepare the query for execution
      $stmt->bind_param('si', $avatarUrl, $groupId); // Bind the parameters: 's' for string (avatar URL), 'i' for integer (group ID)
      $stmt->execute(); // Execute the prepared statement

      echo 'File uploaded and avatar updated successfully.';
    } else {
      echo 'The file must be an image.';
    }
  }
}

// Redirect to the groups page after the operation
header("Location: /groups");
exit();
