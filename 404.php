<?php
session_start();

require_once 'model/connect.php';
require_once 'controller/setting.php';
require 'controller/functions.php';

include 'view/parts/head.php';

// header
include 'view/parts/header.php';

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

include 'view/parts/footer.php';