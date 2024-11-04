<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
  <div class="navbar-nav">
    <a class="nav-link <?php if (!isset($_GET['page'])) { echo 'active';} ?>" href="/">Главная</a>
    <a class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] === 'journal') { echo 'active';} ?>" href="/journal">Дневник</a>
    <a class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] === 'location') { echo 'active';} ?>" href="/location">Локации</a>
    <a class="nav-link <?php if (isset($_GET['page']) && $_GET['page'] === 'settings') { echo 'active';} ?>" href="/settings">Настройки</a>
  </div>
</div>