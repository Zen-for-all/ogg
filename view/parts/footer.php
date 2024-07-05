  <?php if (isset($_SESSION['userid'])) { // user exist ?>
    <footer class="container">
      <div class="clear pT20"></div>
      <hr>
      <div class="clear pT20"></div>
      <a href='controller/logout.php'>Выйти</a>
      <br>
      <a href='/?page=user_delete'>Удалить акаунт</a>
      <div class="clear pT20"></div>
    </footer>
  <?php } ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>