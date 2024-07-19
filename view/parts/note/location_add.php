<?php
if ($locationValue == false) {
  echo '<form action="model/note/add_location.php" method="post">';
} else {
  echo '<form action="model/note/edit_location.php" method="post">';
  echo '<input type="hidden" name="id" value="' . $locationValue . '">';
}
?>
  <p>Заголовок</p>
  <input type="text" class="form-control mb-4" name="title" value="<?php if ($locationTitle != false) { echo $locationTitle; } ?>">

  <p>Описание</p>
  <textarea class="form-control mb-4" name="text"><?php if ($locationText != false) { echo $locationText; } ?></textarea>

  <input class="btn btn-outline-success me-3 mb-4" type="submit">

  <?php unset($locationTitle, $locationText); ?>
</form>