<?php
if ($ldValue == false) {
  echo '<form action="../../model/add_ld.php" method="post">';
} else {
  echo '<form action="../../model/edit_ld.php" method="post">';
  echo '<input type="hidden" name="id" value="' . $ldValue . '">';
}
?>
  <p>Дата</p>
  <input type="date" name="date" value="<?php if ($ldDate != false) { echo $ldDate; } else { echo date("Y-m-d"); } ?>"><br>

  <p>Время</p>
  <input type="time" name="time" value="<?php if ($ldTime != false) { echo $ldTime; } ?>"><br>

  <p>Длительность (сек)</p>
  <input type="number" name="duration" value="<?php if ($ldDuration != false) { echo $ldDuration; } ?>"><br>

  <p>Локация</p>
  <select name="location">
    <option value="0">Выберите локацию</option>

    <?php
    $locationArray = explode(" ", trim($user->ldlocations));

    foreach ($locationArray as $locationValue) {
      $location = new Location($locationValue);
      if ($locationValue == $locationId) {
        echo '<option value="' .  $location->id . '" selected>' . $location->title . '</option>';
      } else {
        echo '<option value="' .  $location->id . '">' . $location->title . '</option>';
      }
    }
    ?>

  </select>
  <br>

  <p>Качество</p>
  <input type="number" name="quality" min="1" max="10" value="<?php if ($ldQuality != false) { echo $ldQuality; } ?>"><br>

  <p>Интерес</p>
  <input type="number" name="interest" min="1" max="10" value="<?php if ($ldInterest != false) { echo $ldInterest; } ?>"><br>

  <p>Метод входа</p>
  <select name="method">
    <option value="0">Выберите метод</option>

    <?php
    foreach ($enterMethod as $key => $value) {
      if ($ldMethod == $value) {
        echo '<option value="' . $key . '" selected>' . $value . '</option>';
      } else {
        echo '<option value="' . $key . '">' . $value . '</option>';
      }
    }
    ?>

  </select>
  <br>

  <p>Описание</p>
  <textarea name="text"><?php if ($ldText != false) { echo $ldText; } ?></textarea>
  <br>

  <p>Заметки</p>
  <textarea name="notice"><?php if ($ldNotice != false) { echo $ldNotice; } ?></textarea>
  <br>

  <input type="submit">

  <?php unset($ldDate, $ldTime, $ldDuration, $locationId, $locationTitle, $ldQuality, $ldInterest, $ldMethod, $ldText, $ldNotice); ?>
</form>