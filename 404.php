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

<div class="d-flex align-items-center justify-content-center vh-100">
  <section class="container text-center">
    <h1>404</h1>
  </section>
</div>
