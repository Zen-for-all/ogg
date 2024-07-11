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
function sortLdObjects(&$ldObjects, $parameter) {
  usort($ldObjects, function($a, $b) use ($parameter) {
    if ($parameter === 'date') {
      // Convert the date to UNIX timestamp
      $dateA = DateTime::createFromFormat('d.m.y', $a->date);
      $dateB = DateTime::createFromFormat('d.m.y', $b->date);

      if ($dateA && $dateB) {
        $timestampA = $dateA->getTimestamp();
        $timestampB = $dateB->getTimestamp();

        if ($timestampA === $timestampB) {
          // If the dates are equal, compare the times
          $timeA = DateTime::createFromFormat('H:i', $a->time);
          $timeB = DateTime::createFromFormat('H:i', $b->time);

          if ($timeA && $timeB) {
            return $timeA->getTimestamp() - $timeB->getTimestamp();
          } else {
            // Handle error if time format is incorrect
            return 0;
          }
        }
        return $timestampA - $timestampB;
      } else {
        // Handle error if date format is incorrect
        return 0;
      }
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

// get ld method percent
function methodPercent($ldArrayObjects) {
  global $enterMethod;

  $countLdList = count($ldArrayObjects); // Counting the number of objects in $ldArrayObjects

  // Initialize variables to count occurrences of each method
  $methodCounts = array_fill_keys($enterMethod, 0);

  // Iterate through each object in $ldArrayObjects and count method occurrences
  foreach ($ldArrayObjects as $ld) {
    $method = $ld->method;

    if ($method >= 1 && $method <= 5) { // Check if $method is within valid range
      $methodCounts[$enterMethod[$method]]++;
    }
  }

  // Calculate percentages and filter out methods with count 0
  $methodPercent = [];
  foreach ($methodCounts as $methodKey => $count) {
    if ($count > 0) {
      $percent = round(($count * 100 / $countLdList), 1);
      $methodPercent[$methodKey] = [$count, $percent];
    }
  }

  return $methodPercent; // Returning the array with method counts and percentages
}

// print graphics ld for the years
function printYears($ldArrayObjects) {
  // Initialize an empty array to hold the count of occurrences for each year.
  $yearsCount = array();

  // Loop through each object in the array.
  foreach ($ldArrayObjects as $ldObject) {
    // Extract the date from the object.
    $date = $ldObject->date;
    // Get the last two digits of the year from the date.
    $year = substr($date, 6, 2);
    // If the year is already in the array, increment its count.
    if (isset($yearsCount[$year])) {
      $yearsCount[$year]++;
    } else {
      // If the year is not in the array, add it with a count of 1.
      $yearsCount[$year] = 1;
    }
  }

  // Find the maximum count of occurrences for any year.
  $maxCount = max($yearsCount);

  // Start outputting the HTML for the year chart.
  echo '<h5 class="mt-4 mb-4">Распределение количества по годам:</h5>';
  echo '<div class="year-chart mb-5">';
  // Loop through each year and its count in the array.
  foreach ($yearsCount as $year => $count) {
    // Calculate the height of the bar as a percentage of the maximum count.
    $height = ($count / $maxCount) * 100;
    // Calculate the width of each bar based on the number of years.
    $width = 100 / count($yearsCount);
    // Output the HTML for each bar with the calculated height and width.
    echo '<div class="bar" style="height: ' . $height . '%; width: ' . $width . '%">';
    // Output the year and the count inside each bar.
    echo '<span class="year">20' . $year . '</span>';
    echo '<span class="count">' . $count . '</span>';
    echo '</div>';
  }
  // Close the year chart div.
  echo '</div>';
}