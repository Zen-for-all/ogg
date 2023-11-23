<?php
session_start();

require_once 'model/connect.php';
require_once 'controller/setting.php';
require 'controller/functions.php';

include 'view/parts/header.php';

if (isset($_SESSION['userid'])) {
  $user = new User($_SESSION['userid']);

  include 'view/parts/menu.php';

  echo '<h1>404</h1>';
} else {
  $title = 'Вход';
  require 'view/pages/enter.php';
}

include 'view/parts/footer.php';