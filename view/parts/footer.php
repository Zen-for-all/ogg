  </section>

  <?php if (isset($_SESSION['userId'])) { // user exist ?>
    <footer class="container-fluid bg-body-tertiary mt-5">
      <div class="container py-3">
        <div class="row">
          <div class="col">
            <a class="btn btn-outline-secondary" href='controller/logout.php'>Выйти</a>
          </div>
          <div class="col">
            <a class="btn btn-outline-danger" href='/?page=user_delete'>Удалить акаунт</a>
          </div>
        </div>
      </div>
    </footer>
  <?php } ?>

  <script defer="" src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
  <script defer="" src="/view/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>