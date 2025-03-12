<?php
/**
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
// Start a session to use session variables
session_start();

// Include the database connection
require '../connect.php';

// Get the user ID from session
$user = $_SESSION['userId'];

// Get and format the input data from the POST request
$date = date("d.m.y", strtotime($_POST['date']));
$time = $_POST['time'];
$duration = $_POST['duration'];
$location = $_POST['location'];
$quality = $_POST['quality'];
$interest = $_POST['interest'];
$method = $_POST['method'];
$text = trim(htmlentities($_POST['text']));
$notice = trim(htmlentities($_POST['notice']));

// Collect hashtags from POST, filter empty values, and encode them as JSON
$hashtags = array_filter([
  trim(htmlentities($_POST['tag_1'])),
  trim(htmlentities($_POST['tag_2'])),
  trim(htmlentities($_POST['tag_3'])),
  trim(htmlentities($_POST['tag_4']))
]);
$jsonHashtags = json_encode($hashtags, JSON_UNESCAPED_UNICODE);

// Get public text, sanitizing it
$public_text = trim(htmlentities($_POST['public_text']));

// Determine whether the post should be published
$publish = isset($_POST['publish']) && $_POST['publish'] === 'on' ? 1 : 0;

// Add a new entry to the learning and development table
$setNewLd = mysqli_query($connect, "
    INSERT INTO `ld` (`date`, `time`, `duration`, `location`, `quality`, `interest`, `method`, `text`, `hashtags`, `public_text`, `publish`, `notice`, `user`, `views`, `likes`)
    VALUES ('$date', '$time', '$duration', '$location', '$quality', '$interest', '$method', '$text', '$jsonHashtags', '$public_text', '$publish', '$notice', '$user', '[]', '[]')
");

// Fetch user data by user ID to get the current learning and development list
$result = mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = '$user'");
$resultldlist = mysqli_fetch_assoc($result);
$ldlist = json_decode($resultldlist['ldlist'], true); // Decode the JSON ldlist into a PHP array

// Get the last inserted learning and development entry ID
$result = mysqli_query($connect, "SELECT `id` FROM `ld` ORDER BY id DESC LIMIT 1;");
$ldlast = mysqli_fetch_assoc($result);

// Initialize a new array for updating the user's learning and development list
$ldnew = !empty($ldlist) ? $ldlist : []; // If the list is not empty, use the existing list

// Add the new learning and development entry ID to the list
$ldnew[] = $ldlast['id'];

// Encode the updated list back into JSON format
$ldnew_json = json_encode($ldnew);

// Update the user's learning and development list in the database
$setNewLdInUser = mysqli_query($connect, "UPDATE `user` SET `ldlist` = '$ldnew_json' WHERE `id` = '$user'");

// Redirect to the journal page after processing
header("location:/journal");
exit();
