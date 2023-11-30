<?php
if ($locationValue === null) {
  echo '<form action="../../model/add_location.php" method="post">';
} else {
  echo '<form action="../../model/edit_location.php" method="post">';
  echo '<input type="hidden" name="id" value="' . $locationValue . '">';
}
?>
  <p>Заголовок</p>
  <input type="text" name="title" value="<?php if ($locationTitle != false) { echo $locationTitle; } ?>">
  <br>

  <p>Описание</p>
  <textarea name="text"><?php if ($locationText != false) { echo $locationText; } ?></textarea>
  <br>

  <input type="submit">
</form>