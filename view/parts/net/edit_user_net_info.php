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
$chat_array = []; // Initialize an empty array to store chat settings
foreach ($сhatList as $key => $chat) {
  // Get the value of the chat input from the form or set it to null if not provided
  $chat_value = $_POST[$chat] ?? null;
  if ($chat_value !== null) {
    $chat_array[$chat] = $chat_value; // Add chat value to the array
  }
}
// Encode the chat array into JSON format without escaping Unicode characters
$chats = json_encode($chat_array, JSON_UNESCAPED_UNICODE);
?>

<div class="row">
  <!-- Avatar Section -->
  <div class="col-md-6 mb-3">
    <?php if (!empty($user->avatar)): ?>
      <div class="row justify-content-start pl-3">
        <div class="avatar-setting">
          <img src="<?= $user->avatar ?>" alt="avatar"> <!-- Display current avatar -->
        </div>

        <!-- Form to delete the avatar -->
        <form action="/model/net/edit_avatar.php" method="post" class="w-auto">
          <button type="submit" name="delete_avatar" class="btn btn-outline-danger mb-3">Удалить аватар</button>
        </form>
      </div>
    <?php endif; ?>

    <!-- Form to upload a new avatar -->
    <form action="/model/net/edit_avatar.php" method="post" enctype="multipart/form-data">
      <label for="avatar" class="form-label"><b>Загрузить аватарку</b></label>
      <input class="form-control mb-3" type="file" name="avatar" id="avatar" accept="image/*"> <!-- File input -->
      <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
    </form>
  </div>

  <!-- Anonymity Section -->
  <div class="col-md-6 mb-3">
    <div class=""><b>Анонимность</b></div>
    <form action="model/edit_anonym.php" method="post">
      <div class="mb-3">
        <!-- Checkbox to toggle anonymity -->
        <label>
          <input class="form-check-input" type="checkbox" name="anonym" value="anonym" <?= $user->anonym == 1 ? 'checked' : ''; ?>>
          <span>Закрытый профиль</span> <span class="grey">(запрещает просмотр вашего профиля)</span>
        </label>
      </div>
      <button class="btn btn-outline-secondary mb-3" type="submit">Сохранить</button>
    </form>
  </div>
</div>

<!-- Profile Settings Section -->
<form action="/model/net/edit_profile.php" method="post">
  <div class="row">
    <div class="col-md-4 mb-3">
      <!-- Name Section -->
      <label for="name" class="form-label"><b>Имя</b></label>
      <input class="form-control" type="text" name="name" id="name" value="<?= $user->name ?>">
    </div>

    <div class="col-md-4 mb-3">
      <!-- Gender Selection -->
      <label for="gender" class="form-label"><b>Ваш пол</b></label>
      <select name="gender" id="gender" class="form-control">
        <option value="select" <?= $user->gender === null ? 'selected' : '' ?>>Выбрать пол</option>
        <option value="male" <?= $user->gender === 'male' ? 'selected' : '' ?>>Мужской</option>
        <option value="female" <?= $user->gender === 'female' ? 'selected' : '' ?>>Женский</option>
      </select>
    </div>

    <div class="col-md-4 mb-3">
      <!-- Birth Year -->
      <label for="birth_year" class="form-label"><b>Год рождения</b></label>
      <input type="number" name="birth_year" id="birth_year" class="form-control" min="1920" max="<?= date('Y') - 10 ?>" value="<?= $user->birth_year ?>">
    </div>

    <div class="col-md-4 mb-3">
      <!-- City -->
      <label for="city" class="form-label"><b>Город проживания</b></label>
      <input class="form-control" type="text" name="city" id="city" value="<?= $user->city ?>">
    </div>

    <div class="col-md-4 mb-3">
      <!-- Experience -->
      <label for="experience" class="form-label"><b>Опыт в Осах (в годах)</b></label>
      <input type="number" name="experience" id="experience" class="form-control" min="0" max="99" value="<?= $user->experience ?>">
    </div>

    <div class="col-md-4 mb-3">
      <!-- Number of Osa -->
      <label for="ldcount" class="form-label"><b>Приблизительное количество Осов</b></label>
      <input type="number" name="ldcount" id="ldcount" class="form-control" min="0" max="9999" value="<?= $user->ldcount ?>">
    </div>

    <div class="col-md-12 mb-3">
      <!-- Description -->
      <label for="description" class="form-label"><b>Описание</b></label>
      <textarea name="description" id="description" class="form-control" rows="4"><?= !empty($user->description) ? htmlspecialchars($user->description) : ''; ?></textarea>
    </div>

    <div class="col-md-4 mb-3">
      <!-- Missions -->
      <label for="mission" class="form-label"><b>Цель аккаунта</b></label>
      <?php
      $userMissions = !empty($user->mission) ? json_decode($user->mission, true) : [];
      foreach ($missionList as $key => $mission): ?>
        <div>
          <input type="checkbox" id="mission_<?= $key ?>" name="mission_<?= $key ?>" value="<?= $key ?>" <?= in_array($key, $userMissions) ? 'checked' : ''; ?>>
          <label for="mission_<?= $key ?>"><?= $mission ?></label>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="col-md-4 mb-3">
      <!-- Ideology -->
      <label for="ideology" class="form-label"><b>Наиболее близкая концепция природы ОСов</b></label>
      <select name="ideology" id="ideology" class="form-select">
        <?php foreach ($ideologyList as $key => $ideology): ?>
          <option value="<?= $key ?>" <?= (isset($user->ideology) && $key == $user->ideology) ? 'selected' : ''; ?>>
            <?= $ideology ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4 mb-3">
      <!-- Contacts -->
      <label for="contacts" class="form-label"><b>Контакты</b></label>
      <?php
      $contacts = $user->contact ? json_decode($user->contact, true) : [];
      foreach ($сhatList as $chat): ?>
        <div class="mb-3">
          <label for="<?= $chat ?>"><?= $chat ?></label>
          <input name="<?= $chat ?>" id="<?= $chat ?>" type="text" placeholder="<?= $chat ?>" value="<?= isset($contacts[$chat]) ? htmlspecialchars($contacts[$chat]) : ''; ?>">
        </div>
      <?php endforeach; ?>
    </div>

    <div class="col-12 mb-3">
      <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
    </div>
  </div>
</form>

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
