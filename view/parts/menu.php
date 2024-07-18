<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
  <div class="navbar-nav">
    <a class="nav-link <?php if (!isset($_GET['page'])) { echo 'active';} ?>" href="/">Главная</a>
    <a class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] === 'journal') { echo 'active';} ?>" href="/?page=journal">Дневник</a>
    <a class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] === 'location') { echo 'active';} ?>" href="/?page=location">Локации</a>
    <a class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] === 'settings') { echo 'active';} ?>" href="/?page=settings">Настройки</a>
  </div>
</div>