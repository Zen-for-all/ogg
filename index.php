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
  $valid_pages = [
    'main', 'journal', 'location', 'settings', 'user_delete',
    'delete_ld_page', 'location_delete', 'ld'
  ];
  $valid_pages_net = ['net', 'groups', 'group'];

  // Check if requested page is valid
  if (in_array($page, $valid_pages)) {
    $require_file = $page === 'main' ? 'view/pages/note/main.php' : "view/pages/note/{$page}.php";
  } elseif (in_array($page, $valid_pages_net)) {
    $net = true;
    $require_file = "view/pages/net/{$page}.php";
  } else {
    // Invalid page - set 404 status
    header("HTTP/1.0 404 Not Found");
    require '404.php';
    exit;
  }

  // Load header
  include 'view/parts/header.php';

  // Load page content
  $title = ucfirst($page === 'main' ? 'Главная' : $page);
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
