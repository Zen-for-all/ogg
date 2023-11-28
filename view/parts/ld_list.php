<?php
/**
 * @var $user
 */
?>

<h2>ОСы</h2><br>

<?php
if (trim($user->ldlist) != '') {
  // get ld id's array
  $ldArray = explode(" ", trim($user->ldlist));

  foreach ($ldArray as $ldValue) {
    // get all info about ld
    $ld = new Ld($ldValue);

    // get all info about location
    $location = new Location($ld->location);

    // print info about ld
    echo 'Дата: ' . $ld->date;
    echo '<br>';
    echo 'Время: ' . $ld->time;
    echo '<br>';
    echo 'Длительность: ' . $ld->duration;
    echo '<br>';
    echo 'Локация: ' . $location->title;
    echo '<br>';
    echo 'Качество: ' . $ld->quality;
    echo '<br>';
    echo 'Интерес: ' . $ld->interest;
    echo '<br>';
    echo 'Метод входа: ' . $enterMethod[$ld->method];
    echo '<br><br>';
    echo 'Описание:<br>' . $ld->text;
    echo '<br><br>';
    echo 'Заметки:<br>' . $ld->notice;
    ?>

    <br><br>

    <!-- button for delete ld -->
    <form action="../../model/delete_ld.php" method="post">
      <input type="hidden" name="delete" value="<?=$ldValue?>">
      <input type="submit" value="Удалить">
    </form>

    <?php
    echo '<br><hr><br>';
  }
}
?>