<?php
session_start();

require_once 'model/connect.php';
require_once 'controller/setting.php';
require 'controller/functions.php';

// head
include 'view/parts/head.php';

if (isset($_SESSION['userid'])) {
  $user = new User($_SESSION['userid']);

  // header
  include 'view/parts/header.php';

  if (isset($_GET['page']) && $_GET['page'] === 'journal') {
    // journal page
    $title = 'Днвник сновидений';
    require 'view/pages/journal.php';
  } elseif (isset($_GET['page']) && $_GET['page'] === 'location') {
    // locations page
    $title = 'Локации';
    require 'view/pages/location.php';
  } else {
    // main page
    $title = 'Главная';
    require 'view/parts/main.php';
  }
} else {
  if (isset($_GET['page']) && $_GET['page'] === 'signing') {
    // register page
    $title = 'Регистрация';
    require 'view/pages/register.php';
  } else {
    // enter page
    $title = 'Вход';
    require 'view/pages/enter.php';
  }
}

// footer
include 'view/parts/footer.php';