<h2 class="mb-3"><?=$user->login?></h2>

<p class="mb-5">В проекте с <?=$user->date?></p>

<div class="row mb-3">
  <div class="col-md-6 mb-3">
    <span><b><?=$user->email?></b></span>

    <form action="../../model/edit_emeil.php" method="post">
      <label for="email" class="form-label">Изменить email</label>
      <input class="form-control mb-3" type="email" name="email" id="email">
      <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
    </form>
  </div>

  <div class="col-md-6 mb-3">
    <form action="../../model/edit_password.php" method="post">
      <span>Пользователь <b><?=$user->login?></b></span><br>
      <label for="password" class="form-label">Изменить пароль</label>
      <input type="text" class="form-control mb-3" name="password" id="password">
      <button type="submit" class="btn btn-outline-secondary mb-3">Сохранить</button>
    </form>
  </div>

  <div class="col-12 mb-3">
    <h3 class="">Анонимность</h3>
    <form action="../../model/edit_anonim.php" method="post">
      <label>
        <p><input class="form-check-input" type="checkbox" name="anonym" value="anonym"
            <?php
            if ($user->anonym == 1) {
              echo ' checked';
            }
            ?>
          > Закрытый профиль</p>
        <button class="btn btn-outline-secondary mb-3" type="submit">Сохранить</button>
      </label>
    </form>
  </div>

  <div class="col-md-6">
    <?php include 'view/parts/import_ld.php'; ?>
  </div>

  <div class="col-md-6">
    <?php include 'view/parts/export_ld.php'; ?>
  </div>
</div>

