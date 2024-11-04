<?php
session_start();

require_once 'model/connect.php';
require_once 'controller/setting.php';
require_once 'controller/functions.php';

if (!isset($_SESSION['userid']) && isset($_COOKIE['userid'])) {
  $_SESSION['userid'] = $_COOKIE['userid'];
}

// head
include 'view/parts/head.php';

// Check if user is logged in
if (isset($_SESSION['userid'])) {
  $user = new User($_SESSION['userid']);

  // net or note part
  $net = false;

  // Determine which page to load based on the 'page' parameter
  if (isset($_GET['page'])) {
    $page = $_GET['page'];

    // List of valid pages
    $valid_pages = [
      'journal',
      'location',
      'settings',
      'user_delete',
      'delete_ld_page',
      'location_delete',
      'ld'
    ];

    $valid_pages_net = [
      'net',
      'groups',
      'group'
    ];

    if (in_array($page, $valid_pages)) {
      $net = false;
      $require_file =  "view/pages/note/{$page}.php";
    } elseif (in_array($page, $valid_pages_net)) {
      $net = true;
      $require_file =  "view/pages/net/{$page}.php";
    }

    // header
    include 'view/parts/header.php';

    if (in_array($page, $valid_pages) || in_array($page, $valid_pages_net)) {
      $title = ucfirst($page); // Capitalize the title
      require $require_file;
    } else {
      // If the page doesn't exist, set the status to 404
      header("HTTP/1.0 404 Not Found");
      require '404.php'; // Load 404 page
    }
  } else {
    // header
    include 'view/parts/header.php';
    // Load the main page if no specific page is requested
    $title = 'Главная';
    require 'view/pages/note/main.php';
  }
} else {
  // User is not logged in, check for login or registration
  if (isset($_GET['page']) && $_GET['page'] === 'signing') {
    // Register page
    $title = 'Регистрация';
    require 'view/pages/note/register.php';
  } else {
    // Login page
    $title = 'Вход';
    require 'view/pages/note/enter.php';
  }
}

// footer
include 'view/parts/footer.php';
