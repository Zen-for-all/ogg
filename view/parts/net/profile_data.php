<?php
/**
 * @var object $user
 * @var array $missionList
 * @var array $ideologyList
 * @var array $сhatList
 * @var int $profile_owner
 */
?>

<?php if ($profile_owner === 0 && $user->anonym == '1'): ?>
  <h2>Профиль анонимный</h2>
<?php elseif ($user->login === null):
  // Redirect to the homepage after processing
  header("Location: /404");
  exit();
else: ?>
  <?php
  if ($user->ldlist) {
    $ldArrayObjects = getLd($user->ldlist);
    $quantityLd = count($ldArrayObjects);
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

  // Decode the user's current missions from JSON to an array or set to an empty array if null
  $userMissions = $user->mission ? json_decode($user->mission, true) : []; // Handle null values gracefully

  // Decode the contact JSON string to an array or set to an empty array if null
  $contacts = $user->contact ? json_decode($user->contact, true) : []; // Handle null values gracefully
  ?>

  <section class="container">
    <div class="row mb-5">
      <h1><?= $user->login ?></h1>

      <?php if ($user->anonym == '1'): ?>
        <i class="small grey">Анонимный профиль</i>
      <?php endif; ?>
    </div>

    <div class="row">
      <div class="col-md-4 col-12">
        <div class="avatar mb-3">
          <?php if (!empty($user->avatar) && file_exists($_SERVER['DOCUMENT_ROOT'] . $user->avatar)): ?>
            <img src="<?= $user->avatar ?>" alt="ava <?= $user->login ?>">
          <?php endif; ?>
        </div>

        <?php if ($user->description != false): ?>
          <div class="">
            <p>О себе:</p>
            <div class=""><?= $user->description ?></div>
          </div>
          <hr>
        <?php endif; ?>

        <?php
        $userGroupIds = $user->grouplist ? json_decode($user->grouplist, true) : [];
        $userGroupIds = is_array($userGroupIds) ? $userGroupIds : [];
        ?>
        <?php if (!empty($userGroupIds)): ?>
          <div class="">
            <p>Группы:</p>
            <div class="">
              <?php foreach ($userGroupIds as $groupId): ?>
                <?php $group = new Group((int)$groupId); ?>
                <?php if (!empty($group->title)): ?>
                  <div>
                    <a href="/?page=group&id=<?= (int)$groupId ?>"><?= htmlspecialchars($group->title) ?></a>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
          <hr>
        <?php endif; ?>
      </div>

      <div class="col-md-8 col-12">
        <?php if ($user->name != false): ?>
          <div class="">
            <p>Имя: <?= $user->name ?></p>
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

        <?php if ($user->city != false): ?>
          <div class="">
            <p>Город: <?= $user->city ?></p>
          </div>
        <?php endif; ?>

        <?php if (!empty($userMissions)): ?>
          <div>
            <p>Цель аккаунта:
              <?php
              // Loop through each mission in the mission list
              foreach ($missionList as $key => $mission):
                ?>
                <?php echo (in_array($key, $userMissions)) ? $mission . ' |' : ''; ?>
              <?php endforeach; ?>
            </p>
          </div>
        <?php endif; ?>

        <?php if ($user->ideology != false): ?>
          <div class="">
            <p>Наиболее близкая концепция природы ОСов: <?= $ideologyList[$user->ideology] ?></p>
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

        <?php if (array_filter($contacts)): ?>
          <div class="">
            <p>Контакты:</p>
            <?php foreach ($сhatList as $chat): ?>
              <?php if ($contacts[$chat] != false): ?>
                <p>
                  <?= $chat ?>:
                  <?php echo htmlspecialchars($contacts[$chat]); ?>
                </p>
              <?php endif; ?>
            <?php endforeach; ?>
            <hr>
          </div>
        <?php endif; ?>

        <?php if ($profile_owner === 1): ?>
          <?php include 'view/parts/net/news-list.php'; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

