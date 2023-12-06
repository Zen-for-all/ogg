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

// get array objects ld from user id
function getLd($ldList) {
  $ldArrayObjects = [];
  $ldArrayId = explode(" ", trim($ldList));

  foreach ($ldArrayId as $ldId) {
    $ld = new Ld($ldId);
    $ldArrayObjects[] = $ld;
  }

  return $ldArrayObjects;
}

// get summ duration
function getQuantity($ldArrayObjects) {
  $summDuration = 0;
  foreach ($ldArrayObjects as $ld) {
    $summDuration += intval($ld->duration);
  }

  return $summDuration;
}

// get average duration
function getAverageDuration($ldArrayObjects) {
  $summDuration = 0;
  $quantityLd = 0;
  foreach ($ldArrayObjects as $ld) {
    if (intval($ld->duration) != 0) {
      $summDuration += intval($ld->duration);
      $quantityLd++;
    }
  }

  $averageDuration = $summDuration / $quantityLd;

  return round($averageDuration);
}

// get average quality
function getAverageQuality($ldArrayObjects) {
  $summQuality = 0;
  $quantityLd = 0;
  foreach ($ldArrayObjects as $ld) {
    if (intval($ld->duration) != 0) {
      $summQuality += intval($ld->quality);
      $quantityLd++;
    }
  }

  $averageDuration = $summQuality / $quantityLd;

  return round($averageDuration, 1);
}

// get average interest
function getAverageInterest($ldArrayObjects) {
  $summInterest = 0;
  $quantityLd = 0;
  foreach ($ldArrayObjects as $ld) {
    if (intval($ld->duration) != 0) {
      $summInterest += intval($ld->interest);
      $quantityLd++;
    }
  }

  $averageInterest = $summInterest / $quantityLd;

  return round($averageInterest, 1);
}