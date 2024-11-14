<?php
/**
 * @var object $user The current user object, containing information about the logged-in user.
 * @var array $missionList The current user object, containing information about the logged-in user.
 * @var array $ideologyList The current user object, containing information about the logged-in user.
 * @var array $сhatList
 */
?>

<?php
// Add Chat settings to an array
$chat_array = [];
foreach ($сhatList as $key => $chat) {
  $chat_value = $_POST[$chat] ?? null; // Get the chat value or null
  if ($chat_value !== null) {
    $chat_array[$chat] = $chat_value; // Store chat value
  }
}
$chats = json_encode($chat_array, JSON_UNESCAPED_UNICODE); // Encode chat array to JSON
?>

<div class="row">
  <div class="col-12 col-md-6 mb-3">
    <?php if (!empty($user->avatar)): ?>
      <div class="row justify-content-start pl-3">
        <div class="avatar-setting">
          <img src="<?= $user->avatar ?>" alt="avatar">
        </div>

        <form action="/model/net/edit_avatar.php" method="post" class="w-auto">
          <button type="submit" name="delete_avatar" class="btn btn-outline-danger mb-3">Удалить аватар</button>
        </form>
      </div>
    <?php endif; ?>

    <form action="/model/net/edit_avatar.php" method="post" enctype="multipart/form-data">
      <label for="avatar" class="form-label"><b>Загрузить аватарку</b></label>
      <input class="form-control mb-3" type="file" name="avatar" id="avatar" accept="image/*">
      <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
    </form>
  </div>

  <div class="col-12 col-md-6 mb-3">
    <div class=""><b>Анонимность</b></div>
    <form action="model/edit_anonym.php" method="post">
      <div class=" mb-3">
        <label>
          <input class="form-check-input" type="checkbox" name="anonym" value="anonym" <?= $user->anonym == 1 ? 'checked' : ''; ?>>
          Закрытый профиль
        </label>
      </div>
      <button class="btn btn-outline-secondary mb-3" type="submit">Сохранить</button>
    </form>
  </div>
</div>

<div class="col-12 col-md-4 mb-3">
  <form action="/model/net/edit_gender.php" method="post">
    <label for="gender" class="form-label"><b>Ваш пол</b></label>
    <select name="gender" id="gender" class="form-control mb-3">
      <option value="select" <?= $user->gender === NULL ? 'selected' : '' ?>>Выбрать пол</option>
      <option value="male" <?= $user->gender === 'male' ? 'selected' : '' ?>>Мужской</option>
      <option value="female" <?= $user->gender === 'female' ? 'selected' : '' ?>>Женский</option>
    </select>
    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>

<div class="col-12 col-md-4 mb-3">
  <form action="/model/net/edit_birth_year.php" method="post">
    <label for="birth_year" class="form-label"><b>Год рождения</b></label>
    <input type="number" name="birth_year" id="birth_year" class="form-control mb-3" min="1920" max="<?= date('Y') - 10 ?>" value="<?= $user->birth_year ?>">
    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>

<div class="col-12 col-md-4 mb-3">
  <form action="/model/net/edit_city.php" method="post">
    <label for="city" class="form-label"><b>Город проживания</b></label>
    <input class="form-control mb-3" type="text" name="city" id="city" value="<?= $user->city ?>">
    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>

<div class="col-12 col-md-4 mb-3">
  <form action="/model/net/edit_experience.php" method="post">
    <label for="experience" class="form-label"><b>Опыт в Осах (в годах)</b></label>
    <input type="number" name="experience" id="experience" class="form-control mb-3" min="0" max="99" value="<?= $user->experience ?>">
    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>

<div class="col-12 col-md-4 mb-3">
  <form action="/model/net/edit_ldcount.php" method="post">
    <label for="ldcount" class="form-label"><b>Приблизительное количество Осов</b></label>
    <input type="number" name="ldcount" id="ldcount" class="form-control mb-3" min="0" max="9999" value="<?= $user->ldcount ?>">
    <button type="submit" class="btn btn-outline-secondary mb-3"><b>Сохранить</b></button>
  </form>
</div>

<div class="col-12 col-md-4 mb-3">
  <form action="/model/net/edit_ideology.php" method="post">
    <label for="ideology" class="form-label"><b>Наиболее близкая концепция природы ОСов</b></label>
    <select name="ideology" id="ideology" class="form-select">
      <?php foreach ($ideologyList as $key => $ideology): ?>
        <option value="<?php echo $key; ?>"
          <?php echo (isset($user->ideology) && $user->ideology !== false && $key == $user->ideology) ? 'selected' : ''; ?>>
          <?php echo $ideology; ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-outline-secondary mb-3 mt-3">Сохранить</button>
  </form>
</div>

<div class="col-12 col-md-4 mb-3">
  <form action="/model/net/edit_description.php" method="post">
    <label for="description" class="form-label"><b>Описание</b></label>
    <textarea name="description" id="description" class="form-control mb-3" rows="4">
      <?php if (!empty($user->description)): ?>
        <?= htmlspecialchars($user->description) ?>
      <?php endif; ?>
    </textarea>
    <button type="submit" class="btn btn-outline-secondary mb-3 mt-3">Сохранить</button>
  </form>
</div>

<div class="col-12 col-md-4 mb-3">
  <form action="/model/net/edit_mission.php" method="post">
    <label for="mission" class="form-label"><b>Цель аккаунта</b></label>

    <?php
    // Decode the user's current missions from JSON to an array
    $userMissions = json_decode($user->mission, true); // Decoding mission JSON into an array

    // Loop through each mission in the mission list
    foreach ($missionList as $key => $mission):
      ?>
      <div>
        <input type="checkbox" id="mission_<?php echo $key; ?>" name="mission_<?php echo $key; ?>"
          <?php echo (in_array($key, $userMissions)) ? 'checked' : ''; ?> />
        <label for="mission_<?php echo $key; ?>"><?php echo $mission; ?></label>
      </div>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-outline-secondary mb-3 mt-3">Сохранить</button>
  </form>
</div>

<div class="col-12 col-md-4 mb-3">
  <form action="/model/net/edit_contact.php" method="post">
    <div class=""><b>Контакты</b></div>

    <?php
    // Decode the contact JSON string to an array
    $contacts = json_decode($user->contact, true); // Convert JSON string to an associative array
    ?>

    <?php foreach ($сhatList as $chat): ?>
      <div class="mb-3">
        <label for="<?php echo $chat; ?>"><?php echo $chat; ?></label>
        <input name="<?php echo $chat; ?>" id="<?php echo $chat; ?>" type="text" placeholder="<?php echo $chat; ?>"
               value="<?php echo isset($contacts[$chat]) ? htmlspecialchars($contacts[$chat]) : ''; ?>">
      </div>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>

<!-- TinyMCE Script Initialization -->
<script src="view/js/tinymce/tinymce.min.js"></script>
<script>
  // Initialize TinyMCE for the public text field
  tinymce.init({
    selector: 'textarea[name="description"]',
    menubar: false,
    plugins: 'lists',
    toolbar: 'undo redo | bold italic | alignleft aligncenter | bullist numlist',
    height: 400
  });
</script>
