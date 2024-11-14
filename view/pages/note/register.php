<div class="d-flex align-items-center justify-content-center vh-100">
  <section class="container text-center">
    <!-- Page title -->
    <h1 class="mb-5"><?php echo $title; ?></h1>

    <!-- Form for registration -->
    <form action="model/signing.php" method="POST" class="col-md-6 col-lg-4 mx-auto">
      <!-- Login input -->
      <input name="login" type="text" class="form-control mb-4" placeholder="login" required>
      <!-- Email input -->
      <input name="email" type="email" class="form-control mb-4" placeholder="email" required>
      <!-- Password input -->
      <input name="password" type="password" class="form-control mb-4" placeholder="password" required>

      <!-- Anonymity checkbox -->
      <div class="form-check mb-3 text-start">
        <label class="form-check-label">
          <input name="anonym" class="form-check-input" type="checkbox">
          Анонимность
        </label>
      </div>

      <!-- Submit button -->
      <input type="submit" class="btn btn-secondary mb-4" value="Зарегистрироваться">

      <!-- Display registration errors -->
      <?php
      if (isset($_SESSION['regError'])) {
        // Define error messages
        $errorMessages = [
          1 => 'Пользователь с таким именем существует',
          2 => 'Длина имени должна быть от 3 до 15 символов',
          3 => 'Заполните все поля'
        ];
        // Display error message if exists
        if (array_key_exists($_SESSION['regError'], $errorMessages)) {
          echo '<div class="alert alert-danger" role="alert">' . $errorMessages[$_SESSION['regError']] . '</div>';
        }
        // Unset error session after display
        unset($_SESSION['regError']);
      }
      ?>
    </form>

    <!-- Link to login page -->
    <div class="mt-3">
      <a class="link-success" href="/">Войти</a>
    </div>
  </section>
</div>
