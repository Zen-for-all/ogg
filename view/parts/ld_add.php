<h2>Добавить запись:</h2>
<form action="../../model/add_ld.php" method="post">
  <p>Дата</p>
  <input type="date" name="date"><br>
  <p>Время</p>
  <input type="time" name="time"><br>
  <p>Длительность (сек)</p>
  <input type="number" name="duration"><br>
  <p>Локация</p>
  <select name="location">
    <option value="0">Выберите локацию</option>

    <?php
    $locationArray = explode(" ", trim($user->ldlocations));

    foreach ($locationArray as $locationValue) {
      $location = new Location($locationValue);
      echo 'Название:' . $location->title;
      echo '<option value="' .  $location->id . '">' . $location->title . '</option>';
    }
    ?>

  </select>
  <br>
  <p>Качество</p>
  <input type="number" name="quality" min="1" max="10"><br>
  <p>Интерес</p>
  <input type="number" name="interest" min="1" max="10"><br>
  <p>Метод входа</p>
  <select name="method">
    <option value="0">Выберите метод</option>

    <?php
    foreach ($enterMethod as $key => $value) {
      echo '<option value="' . $key . '">' . $value . '</option>';
    }
    ?>

  </select>
  <br>

  <p>Описание</p>
  <textarea name="text"></textarea><br>
  <p>Заметки</p>
  <textarea name="notice"></textarea><br>
  <input type="submit">
</form>