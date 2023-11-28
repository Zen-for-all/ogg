<h2>Локации</h2><br>

<?php
$locationArray = explode(" ", trim($user->ldlocations));

foreach ($locationArray as $locationValue) {
  $location = new Location($locationValue);
  echo 'Название:' . $location->title;
  echo '<br>';
  echo 'Описание:' . $location->text;
  echo '<br><br>';
  ?>

  <form action="../../model/delete_location.php" method="post">
    <input type="hidden" name="delete" value="<?=$locationValue?>">
    <input type="submit" value="Удалить">
  </form>

  <?php
  echo '<br><hr><br>';
}
?>