<?php
/**
 * @var string $title The title of the current page or section.
 * @var array $missionList List of missions.
 * @var int $userOnPage Number of users per page.
 */
?>

<h2 class="pb-5"><?= htmlspecialchars($title) ?></h2>

<div class="row mb-5">
  <form action="" method="post">
    <?php
    $missionListId = [];
    foreach ($missionList as $key => $mission):
      // Check if the mission checkbox is checked
      $checked = isset($_POST['mission_' . $key]) && $_POST['mission_' . $key] !== false;
      if ($checked) {
        $missionListId[] = (int)$key; // Convert keys to integers
      }
      ?>
      <div class="rl me-3">
        <input
          type="checkbox"
          id="mission_<?= $key ?>"
          name="mission_<?= $key ?>"
          <?= $checked ? 'checked' : '' ?>
        />
        <label for="mission_<?= $key ?>"><?= htmlspecialchars($mission) ?></label>
      </div>
    <?php endforeach; ?>

    <div class="clear"></div>
    <input type="submit" class="btn btn-outline-secondary mt-3" value="Сортировать по цели">
  </form>
</div>

<div class="row">
  <?php
  // Get the list of all users
  $userArray = getAllUsers();

  // Filter users by exact match of selected missions
  if (!empty($missionListId)) {
    $userArray = array_filter($userArray, function ($user) use ($missionListId) {
      $missionIdArray = json_decode($user->mission, true);

      if (is_array($missionIdArray)) {
        // Check if all selected missions are in the user's missions
        $isMatch = !array_diff($missionListId, $missionIdArray);

        return $isMatch;
      }
      return false;
    });
  }

  // Display users
  if (!empty($userArray)) {
    foreach ($userArray as $user) {
      // Parse missions
      $userMissionArray = [];
      $missionIdArray = json_decode($user->mission, true);
      if ($missionIdArray !== null) {
        foreach ($missionIdArray as $id) {
          if (isset($missionList[$id])) {
            $userMissionArray[] = $missionList[$id];
          }
        }
      }
      ?>

      <!-- Print user info -->
      <div class="location_item col-md-3 mb-5">
        <div class="card px-3 py-3 h100">
          <div class="location_info show">
            <h4 class="mb-3"><?= htmlspecialchars($user->login) ?></h4>

            <?php if (!empty($userMissionArray)) : ?>
              <div>Цель: <?= htmlspecialchars(implode(' | ', $userMissionArray)) ?></div>
            <?php endif; ?>

            <?php if (!empty($user->city)) : ?>
              <div>Город: <?= htmlspecialchars($user->city) ?></div>
            <?php endif; ?>

            <a class="btn btn-outline-secondary mt-4 mb-3" href="/?page=profile&id=<?= htmlspecialchars($user->id) ?>">Подробнее</a>
          </div>
        </div>
      </div>

      <?php
    }
  } else {
    echo '<p class="text-center">Пользователи не найдены.</p>';
  }
  ?>
</div>
