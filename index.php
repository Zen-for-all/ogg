<?php
session_start();

require_once 'model/connect.php';
require_once 'controller/setting.php';
require 'controller/functions.php';

if (!isset($_SESSION['userid']) && isset($_COOKIE['userid'])) {
  $_SESSION['userid'] = $_COOKIE['userid'];
}

// head
include 'view/parts/head.php';

if (isset($_SESSION['userid'])) {
  $user = new User($_SESSION['userid']);

  // header
  include 'view/parts/header.php';

  if (isset($_GET['page']) && $_GET['page'] === 'journal') {
    // journal page
    $title = 'Днвник сновидений';
    require 'view/pages/note/journal.php';
  } elseif (isset($_GET['page']) && $_GET['page'] === 'location') {
    // locations page
    $title = 'Локации';
    require 'view/pages/note/location.php';
  } elseif (isset($_GET['page']) && $_GET['page'] === 'settings') {
    // settings page
    $title = 'Настройки';
    require 'view/pages/note/settings.php';
  } elseif (isset($_GET['page']) && $_GET['page'] === 'user_delete') {
    // delete user page
    $title = 'Удаление аккаунта';
    require 'view/pages/note/delete_user_page.php';
  } elseif (isset($_GET['page']) && $_GET['page'] === 'ld_delete') {
    // delete ld page
    $title = 'Удаление записей';
    require 'view/pages/note/delete_ld_page.php';
  } elseif (isset($_GET['page']) && $_GET['page'] === 'location_delete') {
    // delete locations page
    $title = 'Удаление локаций';
    require 'view/pages/note/delete_location_page.php';
  } elseif (isset($_GET['page']) && $_GET['page'] === 'ld') {
    // Ld page
    $title = 'ОС';
    require 'view/pages/note/ld_page.php';
  } elseif (isset($_GET['page']) && $_GET['page'] === 'net') {
    // NET page
    $title = 'NET';
    require 'view/pages/net/net_page.php';
  } else {
    // main page
    $title = 'Главная';
    require 'view/pages/note/main.php';
  }
} else {
  if (isset($_GET['page']) && $_GET['page'] === 'signing') {
    // register page
    $title = 'Регистрация';
    require 'view/pages/note/register.php';
  } else {
    // enter page
    $title = 'Вход';
    require 'view/pages/note/enter.php';
  }
}

// footer
include 'view/parts/footer.php';