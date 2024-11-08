<?php
/**
 * @var $title
 */
?>

<div class="d-flex align-items-center justify-content-center vh-100">
  <section class="container text-center">
    <h1 class="mb-5"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>

    <div class="row justify-content-center">
      <form action="model/login.php" method="POST" class="col-12 col-md-6 col-lg-4 text-center">
        <input name="login" type="text" class="form-control mb-4" placeholder="login" required>
        <input name="password" type="password" class="form-control mb-4" placeholder="password" required>
        <input type="submit" class="btn btn-secondary mb-4" value="Войти">

        <?php if (!empty($_SESSION['logError'])): ?>
          <div class="alert alert-danger" role="alert">Неверный логин или пароль</div>
          <?php unset($_SESSION['logError']); ?>
        <?php endif; ?>
      </form>
    </div>

    <div class="row justify-content-center">
      <a class="link-success" href="/signing">Зарегистрироваться</a>
    </div>
  </section>
</div>
