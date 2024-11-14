<?php
/**
 * @var string $title The title of the current page or section.
 * @var array $missionList
 * @var $userOnPage
 */
?>

<h2 class="pb-5"><?= htmlspecialchars($title) ?></h2>

<div class="row">
  <?php
  // Get groups
  $userArray = getAllUsers();

  // Get current page and calculate the total pages
  $pages = ceil(count($userArray) / $userOnPage);
  $current_page = isset($_GET['p']) ? (int) $_GET['p'] : 1;

  // Slice the array for the current page
  $start_group = ($current_page - 1) * $userOnPage;
  $userArray = array_slice($userArray, $start_group, $userOnPage);

  // Display groups
  if (!empty($userArray)) {
    foreach ($userArray as $user) {
      // Parse missions
      $userMissionArray = [];
      $missionIdArray = json_decode($user->mission, true);
      if ($missionIdArray !== null) {
        foreach ($missionIdArray as $id) {
          $userMissionArray[] = $missionList[$id];
        }
      }
      ?>

      <!-- Print info about group -->
      <div class="location_item col-md-3 mb-5">
        <div class="card px-3 py-3 h100">
          <div class="location_info show">
            <h4 class="mb-3"><?= $user->login ?></h4>

            <?php if (!empty($userMissionArray)) { ?>
              <div>Цель: <?= implode(' | ', $userMissionArray) ?></div>
            <?php } ?>

            <?php if (!empty($user->city)) : ?>
              <div>Город: <?= $user->city ?></div>
            <?php endif; ?>

            <a class="btn btn-outline-secondary mt-4 mb-3" href="/?page=profile&id=<?= $user->id ?>">Подробнее</a>
          </div>
        </div>
      </div>

      <?php
    }
  }
  ?>
</div>
