<?php
session_start();

if (isset($_SESSION['userid'])) {
  ?>

  <section class="block">
    <h1>404</h1>
  </section>

  <?php
} else {
  $title = 'Вход';
  require 'view/pages/note/enter.php';
}