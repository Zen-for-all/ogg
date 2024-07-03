  <?php if (isset($_SESSION['userid'])) { // user exist ?>
    <footer class="block">
      <div class="clear pT20"></div>
      <hr>
      <div class="clear pT20"></div>
      <a href='controller/logout.php'>Выйти</a>
      <br>
      <a href='/?page=delete'>Удалить акаунт</a>
      <div class="clear pT20"></div>
    </footer>
  <?php } ?>
</body>
</html>