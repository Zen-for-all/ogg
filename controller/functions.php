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

  if ($quantityLd != 0) {
    $averageDuration = $summDuration / $quantityLd;
    return round($averageDuration);
  } else {
    return null;
  }
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

  if ($quantityLd != 0) {
    $averageDuration = $summQuality / $quantityLd;
    return round($averageDuration, 1);
  } else {
    return null;
  }
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

  if ($quantityLd != 0) {
    $averageInterest = $summInterest / $quantityLd;
    return round($averageInterest, 1);
  } else {
    return null;
  }
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

// get excerpt from text
function excerpt($text, $length) {
  // Check if the text length is less than or equal to the desired length
  if (strlen($text) <= $length) {
    return $text;
  }

  // Find the last space within the desired length
  $lastSpace = strrpos(substr($text, 0, $length), ' ');

  // If no space found, truncate to the exact length
  if ($lastSpace === false) {
    return substr($text, 0, $length) . '...';
  }

  // Truncate to the last space and add ellipsis
  return substr($text, 0, $lastSpace) . '...';
}

// sort by parameters
function sortLdObjects(&$ldObjects, $parameter){
  usort($ldObjects, function($a, $b) use ($parameter) {
    if ($parameter === 'date') {
      // Convert the date to UNIX timestamp
      $dateA = DateTime::createFromFormat('d.m.y', $a->date)->getTimestamp();
      $dateB = DateTime::createFromFormat('d.m.y', $b->date)->getTimestamp();
      if ($dateA === $dateB) {
        // If the dates are equal, compare the times
        $timeA = DateTime::createFromFormat('H:i', $a->time)->getTimestamp();
        $timeB = DateTime::createFromFormat('H:i', $b->time)->getTimestamp();
        return $timeA - $timeB;
      }
      return $dateA - $dateB;
    }
    // Compare other parameters as numbers
    return (int)$a->$parameter - (int)$b->$parameter;
  });
}

// get all the information on the array of IDs
function getAllInfo($ldArray) {
  global $connect;
  // Convert array of IDs into a comma-separated string
  $ids = implode(",", $ldArray);
  // SQL query to get all records with IDs in the provided list
  $query = "SELECT * FROM `ld` WHERE `id` IN ($ids)";
  // Execute the query
  $result = mysqli_query($connect, $query);
  // Initialize an array to hold all the information
  $allInfoArray = [];
  // Fetch each row and store it in the array with the ID as the key
  while ($row = mysqli_fetch_assoc($result)) {
    $allInfoArray[$row['id']] = $row;
  }
  // Return the array with all the information
  return $allInfoArray;
}