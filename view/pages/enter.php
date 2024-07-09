<div class="d-flex align-items-center justify-content-center vh-100">
  <section class="container text-center">
    <h1 class="mb-5"><?php echo $title; ?></h1>

    <div class="row justify-content-center">
      <form action="model/login.php" method="POST" class="col-12 col-md-6 col-lg-4 text-center">
        <input name="login" type="text" class="form-control mb-4" placeholder="login">
        <input name="password" type="password" class="form-control mb-4" placeholder="password">
        <input type="submit" class="btn btn-secondary mb-4" value="Войти">

        <?php
        if (isset($_SESSION['logError']) && $_SESSION['logError'] == 1) {
          echo '<div class="alert alert-danger" role="alert">Неверный логин или пароль</div>';
          unset($_SESSION['regError']);
        }
        ?>
      </form>
    </div>

    <div class="row justify-content-center">
      <a class="link-success" href="/?page=signing">Зарегистрироваться</a>
    </div>
  </section>
</div>