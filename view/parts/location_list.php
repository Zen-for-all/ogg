<h2>Локации</h2><br>

<?php
$locationArray = explode(" ", trim($user->ldlocations));

foreach ($locationArray as $locationValue) {
  $location = new Location($locationValue);
  echo 'Название:' . $location->title;
  echo '<br>';
  echo 'Описание:' . $location->text;
  echo '<br>';
  echo '<br><hr><br>';
}
?>