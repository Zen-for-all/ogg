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

  if ($ldList != false) {
    $ldArrayId = explode(" ", trim($ldList));
    foreach ($ldArrayId as $ldId) {
      $ld = new Ld($ldId);
      $ldArrayObjects[] = $ld;
    }

    return $ldArrayObjects;
  }
}

// get summ duration
function getDuration($ldArrayObjects) {
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

// get last ld date
function getLastLdDate($ldArrayObjects) {
  $ldDateLits = [];

  foreach ($ldArrayObjects as $ld) {
    $ldDateLits[] = $ld->date;
  }


  //$lastDate = max($ldDateLits);
  $dateObjects = array_map(function($date) {
    return DateTime::createFromFormat('d.m.y', $date);
  }, $ldDateLits);

  $maxDate  = max($dateObjects);
  $lastDate = $maxDate->format('d.m.y');

  return $lastDate;
}

// get quantity days from last ld
function getIntervalLastLd($lastDate) {
  if ($lastDate != false) {
    $lastDate = DateTime::createFromFormat('d.m.y', $lastDate);
    $today = new DateTime();
    $interval = $today->diff($lastDate);

    return $interval->days;
  }
}

//get all ld
function getAllLd() {
  global $connect;
  $result = mysqli_query($connect, "SELECT id FROM `ld`");

  $idArray = [];
  while($allInfo = mysqli_fetch_assoc($result)) {
    $idArray[] = $allInfo['id'];
  }

  $ldListObjects = [];
  if ($idArray != false) {
    foreach ($idArray as $id) {
      $ld = new Ld($id);
      $ldListObjects[] = $ld;
    }
  }

  return $ldListObjects;
}

// get user quantity
function getUserQuantity() {
  global $connect;
  $result = mysqli_query($connect, "SELECT id FROM `user`");

  return mysqli_num_rows($result);
}

// get average duration
function getLongestLd($ldArrayObjects) {
  $maxDuration = 0;

  foreach ($ldArrayObjects as $object) {
    if ((int)$object->duration > $maxDuration) {
      $maxDuration = (int)$object->duration;
    }
  }

  return round($maxDuration);
}