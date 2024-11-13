<?php
/**
 * @var bool $net Indicates if the "NET" section should be shown.
 */
?>

<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
  <div class="navbar-nav">
    <?php if ($net === true): ?>
      <!-- Links for the "NET" section -->
      <a class="nav-link <?php echo isset($_GET['page']) && $_GET['page'] === 'net' ? 'active' : ''; ?>" href="/net">Профиль</a>
      <a class="nav-link <?php echo isset($_GET['page']) && $_GET['page'] === 'groups' ? 'active' : ''; ?>" href="/groups">Группы</a>
      <a class="nav-link <?php echo isset($_GET['page']) && $_GET['page'] === 'settings-net' ? 'active' : ''; ?>" href="/settings-net">Настройки</a>
    <?php else: ?>
      <!-- Links for the default section -->
      <a class="nav-link <?php echo !isset($_GET['page']) ? 'active' : ''; ?>" href="/">Главная</a>
      <a class="nav-link <?php echo isset($_GET['page']) && $_GET['page'] === 'journal' ? 'active' : ''; ?>" href="/journal">Дневник</a>
      <a class="nav-link <?php echo isset($_GET['page']) && $_GET['page'] === 'location' ? 'active' : ''; ?>" href="/location">Локации</a>
      <a class="nav-link <?php echo isset($_GET['page']) && $_GET['page'] === 'settings' ? 'active' : ''; ?>" href="/settings">Настройки</a>
    <?php endif; ?>
  </div>
</div>
