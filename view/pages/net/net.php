<?php
/**
 * @var object $user
 * @var array $missionList
 * @var array $ideologyList
 * @var array $сhatList
 */
?>

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

// Decode the user's current missions from JSON to an array
$userMissions = json_decode($user->mission, true); // Decoding mission JSON into an array

// Decode the contact JSON string to an array
$contacts = json_decode($user->contact, true); // Convert JSON string to an associative array
?>

<section class="container">
  <div class="row mb-5">
    <h1><?= $user->login ?></h1>
  </div>

  <div class="row">
    <div class="col-md-4 col-12">
      <div class="avatar">
        <?php if (!empty($user->avatar)): ?>
          <img src="<?= $user->avatar ?>" alt="ava <?= $user->login ?>">
        <?php endif; ?>
      </div>
    </div>

    <div class="col-md-8 col-12">
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

      <?php if ($user->ldcount != false): ?>
        <div class="">
          <p>Всего ОСов: <?= $user->ldcount ?></p>
        </div>
      <?php elseif ($quantityLd !== 0): ?>
        <div class="">
          <p>Всего ОСов: <?= $quantityLd ?></p>
        </div>
      <?php endif; ?>

      <?php if ($user->experience != false): ?>
        <div class="">
          <p>Опыт (лет практики): <?= $user->experience ?></p>
        </div>
      <?php endif; ?>

      <?php if ($user->description != false): ?>
        <div class="">
          <p>О себе:</p>
          <div class=""><?= $user->description ?></div>
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

      <?php if (!empty($contacts)): ?>
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
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
