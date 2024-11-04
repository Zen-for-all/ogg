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

  // header
  include 'view/parts/header.php';

  // Determine which page to load based on the 'page' parameter
  if (isset($_GET['page'])) {
    $page = $_GET['page'];

    // List of valid pages
    $valid_pages = [
      'journal',
      'location',
      'settings',
      'user_delete',
      'ld_delete',
      'location_delete',
      'ld'
    ];

    $valid_pages_net = [
      'net',
      'groups'
    ];

    if (in_array($page, $valid_pages)) {
      // Load the corresponding page
      $title = ucfirst($page); // Capitalize the title
      require "view/pages/note/{$page}.php";
    } else if (in_array($page, $valid_pages_net)) {
      // Load the corresponding Net page
      $title = ucfirst($page); // Capitalize the title
      require "view/pages/net/{$page}.php";
    } else {
      // If the page doesn't exist, set the status to 404
      header("HTTP/1.0 404 Not Found");
      require '404.php'; // Load 404 page
    }
  } else {
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
