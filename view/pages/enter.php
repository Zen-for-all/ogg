<h1><?php echo $title; ?></h1>
<div class="clear pT20"></div>

<form action="model/login.php" method="POST">
  <input name="login" type="text" placeholder="login"><br><br>
  <input name="password" type="password" placeholder="password"><br><br>
  <input type="submit" value="Войти">
</form>

<?php
if (isset($_SESSION['logError']) && $_SESSION['logError'] == 1) {
  echo '<br>Неверный логин или пароль<br>';
}

if (isset($_SESSION['regError'])) {
  unset($_SESSION['regError']);
}
?>

<br>
<a href='/?page=signing'>Зарегистрироваться</a><br>