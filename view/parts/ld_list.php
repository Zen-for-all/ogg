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

    $ldDate = $ld->date;
    $ldTime = $ld->time;
    $ldDuration = $ld->duration;
    $locationId = $location->id;
    $locationTitle = $location->title;
    $ldQuality = $ld->quality;
    $ldInterest = $ld->interest;
    $ldMethod = $enterMethod[$ld->method];
    $ldText = $ld->text;
    $ldNotice = $ld->notice;

    // print info about ld
    echo 'Дата: ' . $ldDate;
    echo '<br>';

    if ($ldTime != false) {
      echo 'Время: ' . $ldTime;
      echo '<br>';
    }

    if ($ldDuration != false) {
      echo 'Длительность: ' . $ldDuration;
      echo '<br>';
    }

    if ($locationTitle != false) {
      echo 'Локация: ' . $locationTitle;
      echo '<br>';
    }

    if ($ldQuality != false) {
      echo 'Качество: ' . $ldQuality;
      echo '<br>';
    }

    if ($ldInterest != false) {
      echo 'Интерес: ' . $ldInterest;
      echo '<br>';
    }

    if ($ldMethod != false) {
      echo 'Метод входа: ' . $ldMethod;
      echo '<br>';
    }

    if ($ldText != false) {
      echo '<br>';
      echo 'Описание:<br>' . $ldText;
      echo '<br>';
    }

    if ($ldNotice != false) {
      echo '<br>';
      echo 'Заметки:<br>' . $ldNotice;
      echo '<br>';
    }
    ?>

    <h2>Редактировать запись:</h2>
    <?php include 'ld_add.php'; ?>

    <br><br>

    <!-- button for delete ld -->
    <form action="../../model/delete_ld.php" method="post">
      <input type="hidden" name="delete" value="<?=$ldValue?>">
      <input type="submit" value="Удалить">
    </form>

    <?php
    echo '<br><hr><br>';
  }

  unset($ldValue);
}
?>