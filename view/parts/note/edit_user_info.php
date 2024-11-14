<?php
/**
 * @var object $user The current user object, containing information about the logged-in user.
 */
?>

<div class="col-12 col-md-6 mb-3">
  <span><b><?= $user->email ?></b></span>
  <form action="/model/edit_email.php" method="post">
    <label for="email" class="form-label">Изменить email</label>
    <input class="form-control mb-3" type="email" name="email" id="email" required>
    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>

<div class="col-12 col-md-6 mb-3">
  <form action="model/edit_password.php" method="post">
    <span>Пользователь <b><?= $user->login ?></b></span><br>
    <label for="password" class="form-label">Изменить пароль</label>
    <input type="text" class="form-control mb-3" name="password" id="password" required>
    <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
  </form>
</div>