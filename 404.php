<?php
session_start();

// head
include 'view/parts/head.php';

if (isset($_SESSION['userId'])) {
  ?>

  <section class="block">
    <h1>404</h1>
  </section>

  <?php
} else {
  $title = 'Вход';
  require 'view/pages/note/enter.php';
}