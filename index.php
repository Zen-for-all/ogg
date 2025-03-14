<?php
session_start();

require_once 'model/connect.php';
require_once 'controller/setting.php';
require_once 'controller/functions.php';

// User ID from $_COOKIE to $_SESSION
if (!isset($_SESSION['userId']) && isset($_COOKIE['userId'])) {
  $_SESSION['userId'] = $_COOKIE['userId'];
}

// Load head
include 'view/parts/head.php';

// Check if user is logged in
if (isset($_SESSION['userId'])) {
  $user = new User($_SESSION['userId']);
  $net = false; // Default page type

  // Determine which page to load
  $page = $_GET['page'] ?? 'main'; // Set default page if not provided

  // Define valid page lists
  // LucidNote
  $valid_pages = [
    'main' => 'Главная',
    'journal' => 'Журнал',
    'location' => 'Локации',
    'settings' => 'Настройки',
    'user_delete' => 'Удалить пользователя',
    'ld_delete' => 'Удалить запись',
    'location_delete' => 'Удалить локацию',
    'ld' => 'Запись',
    'faq' => 'FAQ'
  ];
  // LucidNet
  $valid_pages_net = [
    'net' => 'Сеть',
    'groups' => 'Группы',
    'people' => 'Люди',
    'group' => 'Группа',
    'profile' => 'Профиль',
    'posts' => 'Публикации',
    'group_delete' => 'Удалить группу',
    'settings-net' => 'Настройки',
    'post' => 'Запись'
  ];
  // Admin
  $valid_pages_admin = [
    'edit-news' => 'Управление новостями'
  ];

  // Check if requested page is valid
  if (array_key_exists($page, $valid_pages)) {
    $title = $valid_pages[$page]; // Set the title for valid pages
    $require_file = $page === 'main' ? 'view/pages/note/main.php' : "view/pages/note/{$page}.php";
  } elseif (array_key_exists($page, $valid_pages_net)) {
    $net = true;
    $title = $valid_pages_net[$page]; // Set the title for valid net pages
    $require_file = "view/pages/net/{$page}.php";
  } elseif (array_key_exists($page, $valid_pages_admin)) {
    $net = true;
    $title = $valid_pages_admin[$page]; // Set the title for valid admin pages
    $require_file = "view/pages/admin/{$page}.php";
  } else {
    // Invalid page - set 404 status
    header("HTTP/1.0 404 Not Found");
    require '404.php';
    exit;
  }

  // Load header
  include 'view/parts/header.php';

  // Load page content
  require $require_file;

} else {
  // Handle registration and login pages
  $page = $_GET['page'] ?? 'enter';
  $title = $page === 'signing' ? 'Регистрация' : 'Вход';

  $require_file = $page === 'signing' ? 'view/pages/note/register.php' : 'view/pages/note/enter.php';
  require $require_file;
}

// Load footer
include 'view/parts/footer.php';
