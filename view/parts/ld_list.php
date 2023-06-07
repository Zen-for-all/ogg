<h2>ОСы</h2><br>

<?php
$ldArray = explode(" ", $user->ldlist);

foreach ($ldArray as $ldValue) {
  $ld = new Ld($ldValue);
  echo 'Дата:' . $ld->date;
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
  echo '<br><hr><br>';
}
?>