<?php
/**
 * @var $groupMissions
 * @var $groupChat
 * @var $groupValue
 * @var $groupTitle
 * @var $groupText
 * @var $MissionIdArray
 * @var $chats
 */
?>

<?php
if ($groupValue == false) {
  echo '<form action="model/net/add_group.php" method="post" id="add-group-form">';
} else {
  echo '<form action="model/net/edit_group.php" method="post" id="add-group-form">';
  echo '<input type="hidden" name="id" value="' . $groupValue . '">';
}
?>
  <div class="row">
    <div class="col-12 col-md-6">
      <p>Название группы</p>
      <input type="text" class="form-control mb-4" name="title" value="<?php if ($groupTitle != false) { echo $groupTitle; } ?>">
    </div>
    <div class="col-12">
      <p>Описание группы</p>
      <textarea class="form-control mb-4" name="text"><?php if ($groupText != false) { echo $groupText; } ?></textarea>
    </div>
    <div class="col-12 col-md-6">
      <p>Назначение группы:</p>
      <?php foreach ($groupMissions as $key => $mission) { ?>
        <div>
          <input type="checkbox" id="<?php echo 'mission_' . $key; ?>" name="<?php echo 'mission_' . $key; ?>"
            <?php
              if ($groupValue != false) {
                if (in_array($key, $MissionIdArray)) {
                  echo 'checked';
                }
              }
            ?>
          />
          <label for="<?php echo 'mission_' . $key; ?>"><?php echo $mission; ?></label>
        </div>
      <?php } ?>
    </div>
    <div class="col-12 col-md-6">
      <p>Место общения:</p>
      <?php foreach ($groupChat as $key => $chat) { ?>
        <div>
          <label for="<?php echo $chat; ?>"><?php echo $chat; ?></label>
          <input name="<?php echo $chat; ?>" id="<?php echo $chat; ?>" type="text" placeholder="<?php echo $chat; ?>" value="<?php if ($groupValue != false) { echo  $chats[$chat]; } ?>">
        </div>
      <?php } ?>
    </div>
  </div>

  <br>
  <input class="btn btn-outline-success me-3 mb-4" type="submit">
</form>