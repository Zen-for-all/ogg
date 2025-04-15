<?php
$user = new User($_GET['id']);

// If viewed by profile owner
$profile_owner = 0;
?>

<a class="btn btn-light mb-4" href="/people"><- К списку участников</a>

<?php
include 'view/parts/net/profile_data.php';

$ldArray = [];
$ldArray = json_decode($user->ldlist, true);
$ldArray = getPublicLdFromArray($ldArray);
include 'view/parts/net/post_list.php';
?>
