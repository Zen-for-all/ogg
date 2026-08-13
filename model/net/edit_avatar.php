<?php
/**
 * @var object $connect The database connection object used to interact with the MySQL database.
 */

session_start();
require '../connect.php';

// Get user ID from session
$user = intval($_SESSION['userId']); // Ensure the user ID is an integer

// Directory for saving uploaded files
$uploadDir = __DIR__ . '/../../view/uploads/user_avatars/';

// Check if the avatar is being deleted
if (isset($_POST['delete_avatar'])) {
  // Get the current avatar file path from the database
  $query = "SELECT `avatar` FROM `user` WHERE `id` = ?";
  $stmt = $connect->prepare($query);
  $stmt->bind_param('i', $user);
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
  $updateQuery = "UPDATE `user` SET `avatar` = NULL WHERE `id` = ?";
  $stmt = $connect->prepare($updateQuery);
  $stmt->bind_param('i', $user);
  $stmt->execute();

  //echo 'Avatar deleted successfully.';
  header("Location: /settings-net");
  exit();
}

// Check if the file was uploaded
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
  // Get the file extension
  $fileExtension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

  // Generate the filename with 'ava_' prefix and user ID
  $fileName = 'ava_' . $user . '.' . $fileExtension;
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
    $avatarUrl = '/view/uploads/user_avatars/' . $fileName;

    // Prepare the SQL query to update the avatar in the database
    $updateQuery = "UPDATE `user` SET `avatar` = ? WHERE `id` = ?";
    $stmt = $connect->prepare($updateQuery); // Prepare the query for execution
    $stmt->bind_param('si', $avatarUrl, $user); // Bind the parameters: 's' for string (avatar URL), 'i' for integer (user ID)
    $stmt->execute(); // Execute the prepared statement

    //echo 'File uploaded and avatar updated successfully.';
  } else {
    //echo 'The file must be an image.';
  }
}

// Redirect to the settings page after the update
header("Location: /settings-net");
exit();
