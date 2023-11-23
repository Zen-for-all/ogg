<?php
require_once 'setting.php';
require_once 'class/User.php';
require_once 'class/Ld.php';
require_once 'class/Location.php';

// debug function
function de($str) {
  echo "<br><br><br><br><br><br><br><pre>";
  var_dump($str);
  echo "</pre>";
  exit;
}