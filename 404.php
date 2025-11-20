<?php
session_start();

// Include head section
include 'view/parts/head.php';

// Check if user is logged in
if (!isset($_SESSION['userId'])) {
  // If not logged in, set the title and load the login page
  $title = 'Вход';
  require 'view/pages/note/enter.php';
  exit;
}
?>

<nav class="navbar mb-5 navbar-expand-lg bg-body-tertiary sticky-top">
  <div class="container">
    <div class="logo navbar-brand me-5 row">
      <div class="logo-text col gx-0 ms-2 me-1">LUCID</div>
      <div class="logo-switch col ms-0">
        <!-- "NOTE" link will have the 'logo-active' class if $net is false -->
        <a href="/" class="logo-link row">NOTE</a>
        <!-- "NET" link will have the 'logo-active' class if $net is true -->
        <a href="/net" class="logo-link row">NET</a>
      </div>
    </div>
  </div>
</nav>
<br><br><br><br><br>

<div class="d-flex align-items-center justify-content-center">
  <section class="container text-center">
    <h1>404</h1>
  </section>
</div>
<br><br><br><br><br>

<!-- Checking if the user is logged in -->
<?php if (isset($_SESSION['userId'])): ?>
  <footer class="container-fluid bg-body-tertiary mt-5">
    <div class="container py-3">
      <div class="row">
        <div class="col">
          Footer content
        </div>
        <div class="col">
          Footer content
        </div>
      </div>
    </div>
  </footer>
<?php endif; ?>