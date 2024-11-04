<?php
if ($ldValue == false) {
  echo '<form action="model/note/add_ld.php" method="post">';
} else {
  echo '<form action="model/note/edit_ld.php" method="post">';
  echo '<input type="hidden" name="id" value="' . $ldValue . '">';
}
?>
<div class="row">
  <div class="col-6 col-md-4 mb-4">
    <p>Дата</p>

    <?php
    if ($ldDate != false) {
      $dateTime = DateTime::createFromFormat('d.m.y', $ldDate);
      $timestamp = $dateTime->getTimestamp();
      $datePublic =  date("Y-m-d", $timestamp);
    } else {
      $datePublic = date("Y-m-d");
    }
    ?>

    <input type="date" class="form-control" name="date" value="<?=$datePublic?>">
  </div>

  <div class="col-6 col-md-4 mb-4">
    <p>Время</p>
    <?php $formattedTime = $ldTime != false ? date("H:i", strtotime($ldTime)) : ''; ?>
    <input type="time" class="form-control" name="time" value="<?=$formattedTime?>">
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
      // Decode the ldlocations JSON field to an array
      $locationArray = json_decode($user->ldlocations, true);

      if (!empty($locationArray)) {
        foreach ($locationArray as $locationValue) {
          $location = new Location($locationValue);
          $locationId = $location->id;
          $selected = ($locationValue == $ld->location) ? 'selected' : '';
          echo '<option value="' .  $location->id . '" ' . $selected . '>' . $location->title . '</option>';
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
        $selected = ($ldMethod == $value) ? 'selected' : '';
        echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
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

  <div class="col-md-12">
    <p>Хэштеги</p>

    <div class="row">
      <?php
      for ($i = 1; $i <= 4; $i++) {
        if (isset($hashtags[$i-1])) {
          echo '<div class="col-md-3 mb-4"><input type="text" class="form-control no_space" name="tag_' . $i . '" value="' . $hashtags[$i-1] . '"></div>';
        } else {
          echo '<div class="col-md-3 mb-4"><input type="text" class="form-control no_space" name="tag_' . $i . '"></div>';
        }
      }
      ?>
    </div>
  </div>

  <div class="col-md-12 mb-4">
    <p>Публичное описание</p>
    <textarea name="public_text" class="form-control" rows="6"><?php if ($ldPublicText != false) { echo $ldPublicText; } ?></textarea>
    <br>
  </div>

  <div class="col-md-12 mb-4">
    <p>Публикация</p>
    <input type="checkbox" id="publish" name="publish" <?php if ($ldValue == true && $ldPublish == 1) { echo 'checked'; } ?> />
    <label for="publish">Опубликовать</label>
    <br>
  </div>
</div>

<input type="submit" class="btn btn-outline-success me-3">

<?php unset($ldDate, $ldTime, $ldDuration, $locationId, $locationTitle, $ldQuality, $ldInterest, $ldMethod, $ldText, $ldNotice); ?>
</form>

<script src="view/js/tinymce/tinymce.min.js"></script>
<script>
  // add tinymce
  tinymce.init({
    selector: 'textarea[name="public_text"]',
    menubar: false,
    //plugins: 'lists link image table',
    plugins: 'lists link image',
    //toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    toolbar: 'undo redo | bold italic | alignleft aligncenter | bullist numlist',
    height: 400
  });

  // delete spaces to no_space input
  document.addEventListener("DOMContentLoaded", function() {
    const noSpaceInputs = document.querySelectorAll("input.no_space[type='text']");
    noSpaceInputs.forEach(input => {
      // Prevent typing spaces
      input.addEventListener("keypress", function(event) {
        if (event.key === " ") {
          event.preventDefault();
        }
      });
      // Remove spaces after any change
      input.addEventListener("input", function() {
        input.value = input.value.replace(/\s+/g, ""); // Remove all spaces
      });
    });
  });
</script>