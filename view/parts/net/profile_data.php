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

// Decode the user's current missions from JSON to an array or set to an empty array if null
$userMissions = $user->mission ? json_decode($user->mission, true) : []; // Handle null values gracefully

// Decode the contact JSON string to an array or set to an empty array if null
$contacts = $user->contact ? json_decode($user->contact, true) : []; // Handle null values gracefully
?>

<section class="container">
  <div class="row mb-5">
    <h1><?= $user->login ?></h1>
  </div>

  <div class="row">
    <div class="col-md-4 col-12">
      <div class="avatar mb-3">
        <?php if (!empty($user->avatar)): ?>
          <img src="<?= $user->avatar ?>" alt="ava <?= $user->login ?>">
        <?php endif; ?>
      </div>

      <?php if ($user->description != false): ?>
        <div class="">
          <p>О себе:</p>
          <div class=""><?= $user->description ?></div>
        </div>
      <?php endif; ?>
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

      <div class="wall mt-5">
        <hr>
        <div class="wall-title"><b>News</b></div>
        <hr>

        <?php
        // Retrieve an array of news IDs
        $newsIds = getAllNewsIds();

        // Create an array of News objects
        $newsArray = [];
        foreach ($newsIds as $id) {
          $newsArray[] = new News($id);
        }

        // Sort news array by date in descending order
        usort($newsArray, function ($a, $b) {
          return $b->date <=> $a->date; // Sort by date descending
        });

        // Limit the array to 10 items
        $newsArray = array_slice($newsArray, 0, 10);

        // Render news items on the page
        foreach ($newsArray as $news) {
          ?>

          <div class="wall-item mb-3">
            <div class="wall-item-header">
              <div class="wall-item-image">
                <?php if ($news->groupid != false): ?>
                  <img src="view/images/wall-group.svg" alt="icon">
                <?php elseif ($news->eventid != false): ?>
                  <img src="view/images/wall-event.svg" alt="icon">
                <?php else: ?>
                  <img src="view/images/wall-news.svg" alt="icon">
                <?php endif; ?>
              </div>

              <div class="wall-item-title"><b><?= htmlspecialchars($news->title) ?></b></div>
              <div class="wall-item-date small grey"><?= date('d.m.Y (H:i)', $news->date) ?></div>
            </div>

            <div class="wall-item-content"><?= htmlspecialchars($news->text) ?></div>
            <div class="clear"></div>
            <hr>
          </div>

        <?php
        }
        ?>

      </div>
    </div>
  </div>
</section>
