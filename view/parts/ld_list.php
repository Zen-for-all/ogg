<h2>ОСы</h2><br>

<?php
if (trim($user->ldlist) != '') {
  $ldArray = explode(" ", trim($user->ldlist));
  foreach ($ldArray as $ldValue) {
    $ld = new Ld($ldValue);
    echo 'Дата:' . $ldValue;
    echo '<br>';
    echo 'Время:' . $ld->time;
    echo '<br>';
    echo 'Длительность:' . $ld->duration;
    echo '<br>';
    echo 'Локация:' . $ld->location;
    echo '<br>';
    echo 'Качество:' . $ld->quality;
    echo '<br>';
    echo 'Интерес:' . $ld->interest;
    echo '<br>';
    echo 'Метод входа:' . $ld->method;
    echo '<br>';
    echo 'Описание:' . $ld->text;
    echo '<br>';
    echo 'Заметки:' . $ld->notice;
    ?>

    <form action="../../model/delete_ld.php" method="post">
      <input type="hidden" name="delete" value="<?=$ldValue?>">
      <input type="submit" value="Удалить">
    </form>

    <?php
    echo '<br><hr><br>';
  }
}
?>