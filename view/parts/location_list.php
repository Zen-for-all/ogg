<h2>Локации</h2><br>

<?php
// get locations id's array
$locationArray = explode(" ", trim($user->ldlocations));

foreach ($locationArray as $locationValue) {
  // get all info about location
  $location = new Location($locationValue);

  // print info about location
  echo 'Название: ' . $location->title;
  echo '<br>';
  echo 'Описание: ' . $location->text;
  echo '<br><br>';
  ?>

  <!-- button for delete location -->
  <form action="../../model/delete_location.php" method="post">
    <input type="hidden" name="delete" value="<?=$locationValue?>">
    <input type="submit" value="Удалить">
  </form>

  <?php
  echo '<br><hr><br>';
}
?>