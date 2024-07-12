<div class="d-flex align-items-center justify-content-center vh-100">
  <section class="container text-center">
    <h1 class="mb-5"><?php echo $title; ?></h1>

    <div class="row justify-content-center">
      <form action="../../model/signing.php" method="POST" class="col-12 col-md-6 col-lg-4 text-center">
        <input name="login" type="text" class="form-control mb-4" placeholder="login">
        <input name="email" type="email" class="form-control mb-4" placeholder="email">
        <input name="password" type="text" class="form-control mb-4" placeholder="password">

        <div class="row">
          <label class="form-check-label mb-3">
            <input name="anonym" class="form-check-input me-2" type="checkbox">
            Анонимность
          </label>
        </div>

        <input type="submit" class="btn btn-secondary mb-4" value="Зарегистрироваться">

        <?php
        if (isset($_SESSION['regError'])) { // error for registration
          if ($_SESSION['regError'] == 1) { // user name exist
            echo '<div class="alert alert-danger" role="alert">Пользователь с таким именем существует</div>';
          } elseif ($_SESSION['regError'] == 2) { // login very short or long
            echo '<div class="alert alert-danger" role="alert">Длина имени должна быть от 3 до 15 символов</div>';
          } elseif ($_SESSION['regError'] == 3) { // empty input
            echo '<div class="alert alert-danger" role="alert">Заполните все поля</div>';
          }

          unset($_SESSION['regError']);
        }
        ?>
      </form>
    </div>

    <div class="row justify-content-center">
      <a class="link-success" href="/">Войти</a>
    </div>
  </section>
</div>