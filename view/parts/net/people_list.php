<?php
/**
 * @var string $title The title of the current page or section.
 * @var array $missionList List of missions.
 * @var int $userOnPage Number of users per page.
 */
?>

<h2 class="pb-5"><?= htmlspecialchars($title) ?></h2>

<div class="row mb-3">
  <div class="col-md-6">
    <p>Найти по городу</p>
    <form action="/people" method="post">
      <input type="text" class="form-control no_space" name="search"
             value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">

      <?php foreach ($missionList as $key => $mission): ?>
        <?php if (isset($_POST['mission_' . $key])): ?>
          <input type="hidden" name="mission_<?= $key ?>" value="on">
        <?php endif; ?>
      <?php endforeach; ?>

      <input type="submit" value="Искать" class="btn btn-outline-success btn_show mt-3">
    </form>
    <br>

    <?php if (!empty($_POST['search'])) { ?>
      <h3><?= htmlspecialchars($_POST['search']) ?> <a href="/people">(x)</a></h3><br>
    <?php } ?>
  </div>

  <div class="col-md-6">
    <form action="/people" method="post">
      <input type="hidden" name="search" value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">

      <?php
      $missionListId = [];
      foreach ($missionList as $key => $mission):
        $checked = isset($_POST['mission_' . $key]) && $_POST['mission_' . $key] !== false;
        if ($checked) {
          $missionListId[] = (int)$key;
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
</div>

<div class="row">
  <?php
  // Get the list of all users
  $userArray = getAllUsers();

  // Filter users by selected missions
  if (!empty($missionListId)) {
    $userArray = array_filter($userArray, function ($user) use ($missionListId) {
      $missionIdArray = json_decode($user->mission, true);

      if (is_array($missionIdArray)) {
        return !array_diff($missionListId, $missionIdArray);
      }
      return false;
    });
  }

  // Filter users by city if 'search' parameter is provided
  if (!empty($_POST['search'])) {
    $city_title = mb_strtolower($_POST['search']);
    $userArray = array_filter($userArray, function ($user) use ($city_title) {
      return isset($user->city) && mb_strtolower($user->city) === $city_title;
    });
  }

  // Get current page and calculate the total pages
  $pages = ceil(count($userArray) / $userOnPage);
  $current_page = isset($_GET['p']) ? (int) $_GET['p'] : 1;

  // Slice the array for the current page
  $start_group = ($current_page - 1) * $userOnPage;
  $userArray = array_slice($userArray, $start_group, $userOnPage);

  // Display users
  if (!empty($userArray)) {
    foreach ($userArray as $user) {
      // Parse missions
      $userMissionArray = [];

      // Decode the user's mission JSON to an array or set to an empty array if null
      $missionIdArray = $user->mission ? json_decode($user->mission, true) : [];

      if ($missionIdArray !== null) {
        foreach ($missionIdArray as $id) {
          $userMissionArray[] = $missionList[$id];
        }
      }

      if ($user->gender === 'male') {
        $gender = 'мужской';
      } elseif ($user->gender === 'female') {
        $gender = 'женский';
      } else {
        $gender = null;
      }

      if($user->birth_year != false) {
        $age = date("Y") - $user->birth_year;
      }
      ?>

      <!-- Print info about group -->
      <div class="location_item col-lg-3 col-md-6 mb-5">
        <div class="card px-3 py-3 h100">
          <div class="location_info show">
            <a href="/?page=profile&id=<?= htmlspecialchars($user->id) ?>" class="avatar mb-3">
              <?php if (!empty($user->avatar)): ?>
                <img src="<?= $user->avatar ?>" alt="ava <?= $user->login ?>">
              <?php endif; ?>
            </a>

            <h4 class="mb-3"><?= htmlspecialchars($user->login) ?></h4>

            <?php if (!empty($userMissionArray)) { ?>
              <div>
                <p>Цель: <?= implode(' | ', $userMissionArray) ?></p>
              </div>
            <?php } ?>

            <?php if (!empty($user->city)) : ?>
              <div>
                <p>Город: <?= htmlspecialchars($user->city) ?></p>
              </div>
            <?php endif; ?>

            <?php if ($gender != false): ?>
              <div class="">
                <p>Пол: <?= $gender ?></p>
              </div>
            <?php endif; ?>

            <?php if ($user->birth_year != false): ?>
              <div class="">
                <p>Возраст: <?= $age ?></p>
              </div>
            <?php endif; ?>

            <?php if ($user->ldcount != false): ?>
              <div class="">
                <p>Всего ОСов: <?= $user->ldcount ?></p>
              </div>
            <?php elseif (isset($quantityLd) && $quantityLd !== 0): ?>
              <div class="">
                <p>Всего ОСов: <?= $quantityLd ?></p>
              </div>
            <?php endif; ?>

            <?php if ($user->experience != false): ?>
              <div class="">
                <p>Опыт (лет практики): <?= $user->experience ?></p>
              </div>
            <?php endif; ?>

            <a class="btn btn-outline-secondary mt-4 mb-3" href="/?page=profile&id=<?= htmlspecialchars($user->id) ?>">Подробнее</a>
          </div>
        </div>
      </div>

      <?php
    }
  }
  ?>
</div>
