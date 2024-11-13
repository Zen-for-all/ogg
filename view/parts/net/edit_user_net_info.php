<?php
/**
 * @var object $user The current user object, containing information about the logged-in user.
 * @var array $missionList The current user object, containing information about the logged-in user.
 * @var array $ideologyList The current user object, containing information about the logged-in user.
 */
?>

<div class="col-md-6 mb-3">
  <span>Ава <b><?= $user->avatar ?></b></span>
  <form action="/model/net/edit_avatar.php" method="post">
    <label for="avatar" class="form-label">Загрузить аватарку</label>
    <input class="form-control mb-3" type="file" name="avatar" id="avatar" accept="image/*">
    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>

<div class="col-md-6 mb-3">
  <span>Пол <b><?= $user->gender ?></b></span>
  <form action="/model/net/edit_gender.php" method="post">
    <label for="gender" class="form-label">Ваш пол</label>
    <select name="gender" id="gender" class="form-control mb-3">
      <option value="male" <?= $user->gender === '' ? 'selected' : '' ?>>Выбрать пол</option>
      <option value="male" <?= $user->gender === 'male' ? 'selected' : '' ?>>Мужской</option>
      <option value="female" <?= $user->gender === 'female' ? 'selected' : '' ?>>Женский</option>
    </select>
    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>

<div class="col-md-6 mb-3">
  <span>Год рождения <b><?= $user->birth_year ?></b></span>
  <form action="/model/net/edit_birth_year.php" method="post">
    <label for="birth_year" class="form-label">Выбрать год рождения</label>
    <input type="number" name="birth_year" id="birth_year" class="form-control mb-3" min="1920" max="<?= date('Y') - 10 ?>" value="<?= $user->birth_year ?>">
    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>

<div class="col-md-6 mb-3">
  <span><b><?= $user->city ?></b></span>
  <form action="/model/net/edit_city.php" method="post">
    <label for="city" class="form-label">Изменить город</label>
    <input class="form-control mb-3" type="text" name="city" id="city" value="<?= $user->city ?>">
    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>

<div class="col-md-6 mb-3">
  <span>Опыт в Осах (в годах) <b><?= $user->experience ?></b></span>
  <form action="/model/net/edit_experience.php" method="post">
    <label for="experience" class="form-label">Изменить</label>
    <input type="number" name="experience" id="experience" class="form-control mb-3" min="0" max="9999" value="<?= $user->experience ?>">
    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>

<div class="col-md-6 mb-3">
  <span>Приблизительное количество Осов <b><?= $user->ldcount ?></b></span>
  <form action="/model/net/edit_ldcount.php" method="post">
    <label for="ldcount" class="form-label">Изменить количество</label>
    <input type="number" name="ldcount" id="ldcount" class="form-control mb-3" min="0" max="9999" value="<?= $user->ldcount ?>">
    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>

<div class="col-md-6 mb-3">
  <form action="/model/net/edit_description.php" method="post">
    <label for="description" class="form-label">Изменить описание</label>
    <textarea name="description" id="description" class="form-control mb-3" rows="4"><?= htmlspecialchars($user->description) ?></textarea>
    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>

<div class="col-md-6 mb-3">
  <span><b><?= $user->mission ?></b></span>
  <form action="/model/net/edit_mission.php" method="post">
    <label for="mission" class="form-label">Изменить цель аккаунта</label>
    <?php foreach ($missionList as $key => $mission): ?>
      <div>
        <input type="checkbox" id="mission_<?php echo $key; ?>" name="mission_<?php echo $key; ?>"
          <?php echo (isset($groupValue) && $groupValue !== false && in_array($key, $missionIdArray)) ? 'checked' : ''; ?> />
        <label for="mission_<?php echo $key; ?>"><?php echo $mission; ?></label>
      </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-outline-secondary mb-3 mt-3">Сохранить</button>
  </form>
</div>

<div class="col-md-6 mb-3">
  <span><b><?= $user->ideology ?></b></span>
  <form action="/model/net/edit_ideology.php" method="post">
    <label for="email" class="form-label">Изменить взгляд на ОСы</label>
    <?php foreach ($ideologyList as $key => $ideology): ?>
      <div>
        <input type="checkbox" id="ideology_<?php echo $key; ?>" name="ideology_<?php echo $key; ?>"
          <?php echo (isset($groupValue) && $groupValue !== false && in_array($key, $missionIdArray)) ? 'checked' : ''; ?> />
        <label for="ideology_<?php echo $key; ?>"><?php echo $ideology; ?></label>
      </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-outline-secondary mb-3 mt-3">Сохранить</button>
  </form>
</div>

<div class="col-md-6 mb-3">
  <span><b><?= $user->contact ?></b></span>
  <form action="/model/net/edit_contact.php" method="post">
    <label class="form-label">Изменить контакты</label>

    <input class="form-control mb-3" type="text" name="" value="">

    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>

