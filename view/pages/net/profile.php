<?php
$user = new User($_GET['id']);

// If viewed by profile owner
$profile_owner = 0;
?>

<a class="btn btn-light mb-4" href="/people"><- К списку участников</a>

<?php
  include 'view/parts/net/profile_data.php';

  if ($user->ldlist !== null) {
    // Get IDs all lds
    $ldArray = json_decode($user->ldlist, true);

    // Get IDs public lds
    $ldArray = getPublicLdFromArray($ldArray);

    if (is_array($ldArray) && count($ldArray) > 0) {
      include 'view/parts/net/post_list.php';
    }
  }
?>
