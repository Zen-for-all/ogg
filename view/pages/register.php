<div class="d-flex align-items-center justify-content-center vh-100">
  <section class="container text-center">
    <h1 class="mb-5"><?php echo $title; ?></h1>

    <div class="row justify-content-center">
      <form action="../../model/signing.php" method="POST" class="col-12 col-md-6 col-lg-4 text-center">
        <input name="login" type="text" class="form-control mb-4" placeholder="login">
        <input name="password" type="password" class="form-control mb-4" placeholder="password">
        <input name="password" type="text" class="form-control mb-4" placeholder="password">
        <input name="anonym" id="anonym" class="form-check-input" type="checkbox">
        <div class="row text-start">
          <label class="form-check-label" for="anonym">Анонимность</label>
          <input type="submit" class="btn btn-secondary mb-4" value="Зарегистрироваться">
        </div>
      </form>
    </div>

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

    <div class="row justify-content-center">
      <a href="/">Войти</a>
    </div>
  </section>
</div>