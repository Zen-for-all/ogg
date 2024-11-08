<?php
/**
 * @var array $groupMissions List of available group missions.
 * @var array $groupChat List of available chat types for the group.
 * @var mixed $groupValue The group ID if editing, false if creating a new group.
 * @var string $groupTitle The title of the group.
 * @var string $groupText The description of the group.
 * @var array $MissionIdArray List of selected missions for the group.
 * @var array $chats List of current chat values associated with the group.
 */
?>

<form action="<?php echo isset($groupValue) && $groupValue === false ? 'model/net/add_group.php' : 'model/net/edit_group.php'; ?>" method="post" id="add-group-form">
  <?php if (isset($groupValue) && $groupValue !== false): ?>
    <input type="hidden" name="id" value="<?php echo $groupValue; ?>">
  <?php endif; ?>

  <div class="row">
    <!-- Group Title -->
    <div class="col-12 col-md-6">
      <p>Название группы</p>
      <input type="text" class="form-control mb-4" name="title" value="<?php echo $groupTitle ?: ''; ?>">
    </div>

    <!-- Group Description -->
    <div class="col-12">
      <p>Описание группы</p>
      <textarea class="form-control mb-4" name="text"><?php echo $groupText ?: ''; ?></textarea>
    </div>

    <!-- Missions Selection -->
    <div class="col-12 col-md-6">
      <p>Назначение группы:</p>
      <?php foreach ($groupMissions as $key => $mission): ?>
        <div>
          <input type="checkbox" id="mission_<?php echo $key; ?>" name="mission_<?php echo $key; ?>"
            <?php echo (isset($groupValue) && $groupValue !== false && in_array($key, $MissionIdArray)) ? 'checked' : ''; ?> />
          <label for="mission_<?php echo $key; ?>"><?php echo $mission; ?></label>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Chat Selection -->
    <div class="col-12 col-md-6">
      <p>Место общения:</p>
      <?php foreach ($groupChat as $chat): ?>
        <div>
          <label for="<?php echo $chat; ?>"><?php echo $chat; ?></label>
          <input name="<?php echo $chat; ?>" id="<?php echo $chat; ?>" type="text" placeholder="<?php echo $chat; ?>"
                 value="<?php echo (isset($groupValue) && $groupValue !== false) ? $chats[$chat] : ''; ?>">
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <br>
  <input class="btn btn-outline-success me-3 mb-4" type="submit">
</form>
