<section class="container">
  <h1><?php echo $title; ?></h1>
  <div class="clear pT20"></div>

  <form action="../../model/signing.php" method="POST">
    <input name="login" type="text" placeholder="login"><br><br>
    <input name="email" type="email" placeholder="email"><br><br>
    <input name="password" type="text" placeholder="password"><br><br>
    <input name="anonym" id="anonym" type="checkbox">
    <label for="anonym">Анонимность</label>
    <br><br>
    <input type="submit" value="Зарегистрироваться">
  </form>

  <?php
  if (isset($_SESSION['regError'])) { // error for registration
    if ($_SESSION['regError'] == 1) { // user name exist
      echo '<br>Пользователь с таким именем существует<br>';
    } elseif ($_SESSION['regError'] == 2) { // login very short or long
      echo '<br>Длина имени должна быть от 3 до 15 символов<br>';
    } elseif ($_SESSION['regError'] == 3) { // empty input
      echo '<br>Заполните все поля<br>';
    }
  }

  if (isset($_SESSION['regError'])) {
    unset($_SESSION['regError']);
  }
  ?>

  <br>
  <a href="/">Войти</a>
</section>