<?php
if ($ldValue == false) {
  echo '<form action="../../model/add_ld.php" method="post">';
} else {
  echo '<form action="../../model/edit_ld.php" method="post">';
  echo '<input type="hidden" name="id" value="' . $ldValue . '">';
}
?>
  <div class="row">
    <div class="col-6 col-md-4 mb-4">
      <p>Дата</p>
      <?php
      $timestamp = strtotime($ldDate);
      $formattedDate = date("Y-m-d", $timestamp);
      ?>
      <input type="date" class="form-control" name="date" value="<?php if ($ldDate != false) { echo $formattedDate; } else { echo date("Y-m-d"); } ?>">
    </div>

    <div class="col-6 col-md-4 mb-4">
      <p>Время</p>
      <?php $formattedTime = date("H:i", strtotime($ldTime)); ?>
      <input type="time" class="form-control" name="time" value="<?php if ($formattedTime != false) { echo $formattedTime; } ?>">
    </div>

    <div class="col-4 col-md-4 mb-4">
      <p>Длит. (сек)</p>
      <input type="number" class="form-control" name="duration" value="<?php if ($ldDuration != false) { echo $ldDuration; } ?>">
    </div>

    <div class="col-4 col-md-2 mb-4">
      <p>Качество</p>
      <input type="number" class="form-control" name="quality" min="1" max="10" value="<?php if ($ldQuality != false) { echo $ldQuality; } ?>">
    </div>

    <div class="col-4 col-md-2 mb-4">
      <p>Интерес</p>
      <input type="number" class="form-control" name="interest" min="1" max="10" value="<?php if ($ldInterest != false) { echo $ldInterest; } ?>">
    </div>

    <div class="col-md-4 col-sm-6 mb-4">
      <p>Локация</p>
      <select name="location" class="form-control">
        <option value="0">Выберите локацию</option>

        <?php
        $locationArray = explode(" ", trim($user->ldlocations));

        if ($user->ldlocations !== null) {
          foreach ($locationArray as $locationValue) {
            $location = new Location($locationValue);
            $locationId = $location->id;
            if ($locationValue == $ld->location) {
              echo '<option value="' .  $location->id . '" selected>' . $location->title . '</option>';
            } else {
              echo '<option value="' .  $location->id . '">' . $location->title . '</option>';
            }
          }
        }
        ?>

      </select>
    </div>

    <div class="col-md-4 col-sm-6 mb-4">
      <p>Метод входа</p>
      <select name="method" class="form-control">
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
    </div>

    <div class="col-md-12 mb-4">
      <p>Описание</p>
      <textarea name="text" class="form-control" rows="6"><?php if ($ldText != false) { echo $ldText; } ?></textarea>
      <br>
    </div>

    <div class="col-md-12 mb-4">
      <p>Заметки</p>
      <textarea name="notice" class="form-control" rows="3"><?php if ($ldNotice != false) { echo $ldNotice; } ?></textarea>
    </div>
  </div>

  <input type="submit" class="btn btn-success me-3">

  <?php unset($ldDate, $ldTime, $ldDuration, $locationId, $locationTitle, $ldQuality, $ldInterest, $ldMethod, $ldText, $ldNotice); ?>
</form>