<?php
/**
 * @var bool $net Indicates if the "NET" link should be active.
 */
?>

<nav class="navbar mb-5 navbar-expand-lg bg-body-tertiary sticky-top">
  <div class="container">
    <div class="logo navbar-brand me-5 row">
      <div class="logo-text col gx-0 ms-2 me-1">LUCID</div>
      <div class="logo-switch col ms-0">
        <!-- "NOTE" link will have the 'logo-active' class if $net is false -->
        <a href="/" class="logo-link row<?php echo !$net ? ' logo-active' : ''; ?>">NOTE</a>
        <!-- "NET" link will have the 'logo-active' class if $net is true -->
        <a href="/net" class="logo-link row<?php echo $net ? ' logo-active' : ''; ?>">NET</a>
      </div>
    </div>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <?php include 'menu.php'; ?>
  </div>
</nav>

<section class="container">
