<h2><?=$user->login?></h2>
<div class="clear pT20"></div>

<p>В проекте с <?=$user->date?></p>
<div class="clear pT20"></div>

<p><?=$user->email?></p>

<form action="../../model/edit_emeil.php" method="post">
  <p>Изменить email</p>
  <input type="email" name="email">
  <div class="clear"></div>
  <button type="submit">Сохранить</button>
</form>
<div class="clear pT20"></div>

<form action="../../model/edit_password.php" method="post">
  <p>Изменить пароль</p>
  <input type="text" name="password">
  <div class="clear"></div>
  <button type="submit">Сохранить</button>
</form>
<div class="clear pT20"></div>

<h2>Анонимность</h2>
<form action="../../model/edit_anonim.php" method="post">
  <label>
    <p><input type="checkbox" name="anonym" value="anonym"
        <?php
        if ($user->anonym == 1) {
          echo ' checked';
        }
        ?>
      > Закрытый профиль</p>
    <button type="submit">Сохранить</button>
  </label>
</form>