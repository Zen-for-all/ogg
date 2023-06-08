<?php
session_start();

require_once 'model/connect.php';
require_once 'controller/setting.php';
require 'controller/functions.php';

include 'view/parts/header.php';

if (isset($_SESSION['userid'])) {
  $user = new User($_SESSION['userid']);

  include 'view/parts/menu.php';

  if (isset($_GET['page']) && $_GET['page'] == 'journal') {
    $title = 'Днвник сновидений';
    require 'view/pages/journal.php';
  } elseif (isset($_GET['page']) && $_GET['page'] == 'location') {
    $title = 'Локации';
    require 'view/pages/location.php';
  } else {
    $title = 'Главная';
    require 'view/parts/main.php';
  }
} else {
  if (isset($_GET['page']) && $_GET['page'] == 'signing') { // register page
    $title = 'Регистрация';
    require 'view/pages/register.php';
  } else { // enter page
    $title = 'Вход';
    require 'view/pages/enter.php';
  }
}

include 'view/parts/footer.php';