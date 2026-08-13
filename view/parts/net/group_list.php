<?php
/**
 * @var object $user The current user object, containing information about the logged-in user.
 * @var string $title The title of the current page or section.
 * @var array $missionList List of available group missions that can be assigned to a group.
 * @var array $groupOnPage List of groups or information related to the groups displayed on the page.
 */
?>

<h1 class="pb-5"><?= htmlspecialchars($title) ?></h1>

<div class="row mb-3">
  <div class="col-md-6">
    <p>Найти по названию</p>
    <form action="/groups" method="post">
      <input type="text" class="form-control no_space" name="search"
             value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
      <input type="submit" value="Искать" class="btn btn-outline-success btn_show mt-3">
    </form>
    <br>

    <?php if (!empty($_POST['search'])) { ?>
      <h3><?= htmlspecialchars($_POST['search']) ?> <a href="/groups">(x)</a></h3><br>
    <?php } ?>
  </div>

  <div class="col-md-6">
    <form action="" method="post">
      <?php
      $missionListId = [];
      foreach ($missionList as $key => $mission):
        $checked = isset($_POST['mission_' . $key]) && $_POST['mission_' . $key] !== false;
        if ($checked) $missionListId[] = $key;
        ?>
        <div class="rl me-3">
          <input type="checkbox" id="mission_<?php echo $key; ?>" name="mission_<?php echo $key; ?>" <?php echo $checked ? 'checked' : ''; ?> />
          <label for="mission_<?php echo $key; ?>"><?php echo $mission; ?></label>
        </div>
      <?php endforeach; ?>

      <div class="clear"></div>
      <input type="submit" class="btn btn-outline-secondary mt-3" value="Сортировать по цели">
    </form>
  </div>
</div>

<div class="row">
  <?php
  // Get groups
  $groupArray = getAllGroups($missionListId);

  // Filter groups by title if 'search' parameter is provided
  if (!empty($_POST['search'])) {
    $group_title = mb_strtolower($_POST['search']);
    $groupArray = array_filter($groupArray, function ($group) use ($group_title) {
      return isset($group->title) && mb_strpos(mb_strtolower($group->title), $group_title) !== false;
    });
  }

  // Get current page and calculate the total pages
  $pages = ceil(count($groupArray) / $groupOnPage);
  $current_page = isset($_GET['p']) ? (int) $_GET['p'] : 1;

  // Slice the array for the current page
  $start_group = ($current_page - 1) * $groupOnPage;
  $groupArray = array_slice($groupArray, $start_group, $groupOnPage);

  // Display groups
  if (!empty($groupArray)) {
    foreach ($groupArray as $group) {
      $groupAvatar = $group->avatar;
      $groupTitle = htmlspecialchars($group->title);
      $groupCity = $group->city;
      $groupAdminId = $group->admin;
      $admin = new User($groupAdminId);

      // Parse missions
      $groupMissionArray = [];
      $missionIdArray = json_decode($group->mission, true);
      foreach ($missionIdArray as $id) {
        $groupMissionArray[] = $missionList[$id];
      }

      // Parse users
      $userIdArray = json_decode($group->users, true);
      $userCount = count($userIdArray);

      // Get city name
      $groupCity = $group->city;
      ?>

      <!-- Print info about group -->
      <div class="location_item col-lg-6 mb-5 <?= in_array($_SESSION['userId'], $userIdArray) ? 'group-active' : '' ?>">
        <div class="card card-group px-3 py-3 h100">
          <div class="location_info show">
            <a href="/?page=group&id=<?= htmlspecialchars($group->id) ?>" class="avatar">
              <?php if (!empty($groupAvatar) && file_exists($_SERVER['DOCUMENT_ROOT'] . $groupAvatar)): ?>
                <img src="<?= $groupAvatar ?>" alt="ava">
              <?php endif; ?>
            </a>

            <h4 class="mb-3"><?= $groupTitle ?></h4>

            <?php if (!empty($groupMissionArray)) { ?>
              <div>Цель: <?= implode(' | ', $groupMissionArray) ?></div>
            <?php } ?>

            <?php if (!empty($groupCity)) : ?>
              <div>Город: <?= $groupCity ?></div>
            <?php endif; ?>

            <div>Участников: <?= $userCount ?></div>

            <div>Админ: <a href="/?page=profile&id=<?= $groupAdminId ?>"><?= $admin->login ?></a></div>

            <a class="btn btn-outline-secondary mt-4 mb-3" href="/?page=group&id=<?= $group->id ?>">Подробнее</a>
          </div>
        </div>
      </div>

      <?php
    }
  }
  ?>
</div>
