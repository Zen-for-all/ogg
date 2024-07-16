<nav class="navbar mb-5 navbar-expand-lg bg-body-tertiary sticky-top">
  <div class="container">
    <a class="navbar-brand me-5" href="/">OGG</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link <?php if (!isset($_GET['page'])) { echo 'active';} ?>" href="/">Главная</a>
        <a class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] === 'journal') { echo 'active';} ?>" href="/?page=journal">Дневник</a>
        <a class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] === 'location') { echo 'active';} ?>" href="/?page=location">Локации</a>
        <a class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] === 'settings') { echo 'active';} ?>" href="/?page=settings">Настройки</a>
      </div>
    </div>
  </div>
</nav>