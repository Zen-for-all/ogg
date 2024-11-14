<?php
/**
 * @var object $user The current user object, containing information about the logged-in user.
 * @var object $ld The current record object, which holds the data for the specific "ld" entry being edited or added.
 * @var bool|string $ldValue Contains a unique identifier for the current "ld" record if it exists, or `false` if it's a new entry.
 * @var string|false $ldDate The date associated with the "ld" record. It is a string in the format 'd.m.y', or `false` if not set.
 * @var string|false $ldTime The time associated with the "ld" record in 'H:i' format, or `false` if not set.
 * @var int|false $ldDuration The duration of the "ld" event, in seconds, or `false` if not set.
 * @var int|false $ldQuality The quality rating of the "ld" record, an integer between 1 and 10, or `false` if not set.
 * @var int|false $ldInterest The interest rating for the "ld" record, an integer between 1 and 10, or `false` if not set.
 * @var array $enterMethod An array of methods for entering the "ld" record. It could contain various options like "method1", "method2", etc.
 * @var string|false $ldMethod The method used for entering the "ld" record. It can be any value from the `$enterMethod` array, or `false` if not set.
 * @var string|false $ldText A general description or notes related to the "ld" record, or `false` if not set.
 * @var string|false $ldNotice Additional notices or comments for the "ld" record, or `false` if not set.
 * @var string|false $ldPublicText A publicly visible description for the "ld" record, used for display purposes, or `false` if not set.
 * @var bool $ldPublish Indicates whether the "ld" record is marked for publication. It's a boolean value (`true` or `false`).
 */
?>

<?php
// Determine whether the form is for adding or editing based on the value of $ldValue
if ($ldValue == false) {
  echo '<form action="model/note/add_ld.php" method="post">';
} else {
  echo '<form action="model/note/edit_ld.php" method="post">';
  echo '<input type="hidden" name="id" value="' . $ldValue . '">'; // Hidden input for editing an existing entry
}
?>
<div class="row">
  <!-- Date Field -->
  <div class="col-6 col-md-4 mb-4">
    <p>Дата</p>
    <?php
    // If there is an existing date, format it, otherwise set the current date
    if ($ldDate != false) {
      $dateTime = DateTime::createFromFormat('d.m.y', $ldDate);
      $timestamp = $dateTime->getTimestamp();
      $datePublic = date("Y-m-d", $timestamp);
    } else {
      $datePublic = date("Y-m-d");
    }
    ?>
    <input type="date" class="form-control" name="date" value="<?=$datePublic?>">
  </div>

  <!-- Time Field -->
  <div class="col-6 col-md-4 mb-4">
    <p>Время</p>
    <?php $formattedTime = $ldTime != false ? date("H:i", strtotime($ldTime)) : ''; ?>
    <input type="time" class="form-control" name="time" value="<?=$formattedTime?>">
  </div>

  <!-- Duration Field -->
  <div class="col-4 col-md-4 mb-4">
    <p>Длит. (сек)</p>
    <input type="number" class="form-control" name="duration" value="<?php if ($ldDuration != false) { echo $ldDuration; } ?>">
  </div>

  <!-- Quality Field -->
  <div class="col-4 col-md-2 mb-4">
    <p>Качество</p>
    <input type="number" class="form-control" name="quality" min="1" max="10" value="<?php if ($ldQuality != false) { echo $ldQuality; } ?>">
  </div>

  <!-- Interest Field -->
  <div class="col-4 col-md-2 mb-4">
    <p>Интерес</p>
    <input type="number" class="form-control" name="interest" min="1" max="10" value="<?php if ($ldInterest != false) { echo $ldInterest; } ?>">
  </div>

  <!-- Location Dropdown -->
  <div class="col-md-4 col-sm-6 mb-4">
    <p>Локация</p>
    <select name="location" class="form-control">
      <option value="0">Выберите локацию</option>
      <?php
      // Decode the locations JSON field to an array
      $locationArray = json_decode($user->ldlocations, true);
      if (!empty($locationArray)) {
        foreach ($locationArray as $locationValue) {
          $location = new Location($locationValue);
          $locationId = $location->id;
          $selected = ($locationValue == $ld->location) ? 'selected' : ''; // Check if the location is selected
          echo '<option value="' .  $location->id . '" ' . $selected . '>' . $location->title . '</option>';
        }
      }
      ?>
    </select>
  </div>

  <!-- Method Dropdown -->
  <div class="col-md-4 col-sm-6 mb-4">
    <p>Метод входа</p>
    <select name="method" class="form-control">
      <option value="0">Выберите метод</option>
      <?php
      // Loop through available entry methods and display them in the dropdown
      foreach ($enterMethod as $key => $value) {
        $selected = ($ldMethod == $value) ? 'selected' : ''; // Check if the method is selected
        echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
      }
      ?>
    </select>
  </div>

  <!-- Description Field -->
  <div class="col-md-12 mb-4">
    <p>Описание</p>
    <textarea name="text" class="form-control" rows="6"><?php if ($ldText != false) { echo $ldText; } ?></textarea>
  </div>

  <!-- Notes Field -->
  <div class="col-md-12 mb-4">
    <p>Заметки</p>
    <textarea name="notice" class="form-control" rows="3"><?php if ($ldNotice != false) { echo $ldNotice; } ?></textarea>
  </div>

  <!-- Hashtags Fields -->
  <div class="col-md-12">
    <p>Хэштеги</p>
    <div class="row">
      <?php
      // Loop to create input fields for hashtags (up to 4)
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

  <!-- Public Text Field -->
  <div class="col-md-12 mb-4">
    <p>Публичное описание</p>
    <textarea name="public_text" class="form-control" rows="6"><?php if ($ldPublicText != false) { echo $ldPublicText; } ?></textarea>
  </div>

  <!-- Publish Checkbox -->
  <div class="col-md-12 mb-4">
    <p>Публикация</p>
    <input type="checkbox" id="publish" name="publish" <?php if ($ldValue == true && $ldPublish == 1) { echo 'checked'; } ?> />
    <label for="publish">Опубликовать</label>
  </div>
</div>

<!-- Submit Button -->
<input type="submit" class="btn btn-outline-success me-3">

<?php unset($ldDate, $ldTime, $ldDuration, $locationId, $locationTitle, $ldQuality, $ldInterest, $ldMethod, $ldText, $ldNotice); ?>
</form>

<!-- TinyMCE Script Initialization -->
<script src="view/js/tinymce/tinymce.min.js"></script>
<script>
  // Initialize TinyMCE for the public text field
  tinymce.init({
    selector: 'textarea[name="public_text"]',
    menubar: false,
    plugins: 'lists',
    toolbar: 'undo redo | bold italic | alignleft aligncenter | bullist numlist',
    height: 400
  });

  // Prevent spaces in hashtag input fields
  document.addEventListener("DOMContentLoaded", function() {
    const noSpaceInputs = document.querySelectorAll("input.no_space[type='text']");
    noSpaceInputs.forEach(input => {
      input.addEventListener("keypress", function(event) {
        if (event.key === " ") {
          event.preventDefault();
        }
      });
      input.addEventListener("input", function() {
        input.value = input.value.replace(/\s+/g, ""); // Remove all spaces
      });
    });
  });
</script>
