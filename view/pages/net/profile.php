<?php
$user = new User($_GET['id']);
?>

<a class="btn btn-light mb-4" href="/people"><- К списку участников</a>

<?php
include 'view/parts/net/profile_data.php';
?>
