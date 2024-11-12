<?php
/**
 * @var object $user The current user object, containing information about the logged-in user.
 * @var string $title The title of the current page or section.
 * @var array $groupMissions List of available group missions that can be assigned to a group.
 * @var array $groupChat List of available chat types or channels associated with the group.
 * @var array $groupOnPage List of groups or information related to the groups displayed on the page.
 */
?>

<h2 class="pb-5"><?= htmlspecialchars($title) ?></h2> <!-- Escaping title for security -->

<div class="row">

  <?php
  // Get groups
  $groupArray = getAllGroups();

  // Get current page and calculate the total pages
  $pages = ceil(count($groupArray) / $groupOnPage);
  $current_page = isset($_GET['p']) ? (int) $_GET['p'] : 1;

  // Slice the array for the current page
  $start_group = ($current_page - 1) * $groupOnPage;
  $groupArray = array_slice($groupArray, $start_group, $groupOnPage);

  // Display groups
  if (!empty($groupArray)) {
    foreach ($groupArray as $group) {
      $groupTitle = htmlspecialchars($group->title);  // Escaping for security
      $groupAdminId = $group->admin;
      $admin = new User($groupAdminId);

      // Parse missions
      $groupMissionArray = [];
      $MissionIdArray = json_decode($group->mission, true);
      foreach ($MissionIdArray as $id) {
        $groupMissionArray[] = $groupMissions[$id];
      }

      // Parse users
      $userIdArray = json_decode($group->users, true);
      $userCount = count($userIdArray);
      ?>

      <!-- Print info about group -->
      <div class="location_item col-md-6 mb-5 <?= in_array($_SESSION['userId'], $userIdArray) ? 'group-active' : '' ?>">
        <div class="card px-3 py-3 h100">
          <div class="location_info show">
            <h4 class="mb-3"><?= $groupTitle ?></h4>

            <?php if (!empty($groupMissionArray)) { ?>
              <span><b>Цели:</b></span>
              <p>
                <?= implode(' | ', $groupMissionArray) ?> <!-- Using implode for cleaner code -->
              </p>
            <?php } ?>

            <p>Участников: <?= $userCount ?></p>

            <p>Админ: <a href="/?user=<?= $groupAdminId ?>"><?= $admin->login ?></a></p>

            <a class="btn btn-outline-secondary mt-4 mb-3" href="/?page=group&id=<?= $group->id ?>">Подробнее</a>
          </div>
        </div>
      </div>

      <?php
    }
  }
  ?>

</div>
