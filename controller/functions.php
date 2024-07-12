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

// print graphics ld for the: years (null), duration, quality, interest
function printYears($ldArrayObjects, $param = null) {
  // Initialize an empty array to hold the count of occurrences for each year or the sum of the param values.
  $yearsData = array();

  // Loop through each object in the array.
  foreach ($ldArrayObjects as $ldObject) {
    // Extract the date from the object.
    $date = $ldObject->date;
    // Get the last two digits of the year from the date.
    $year = substr($date, 6, 2);

    // Initialize year data if not already set
    if (!isset($yearsData[$year])) {
      $yearsData[$year] = ['count' => 0, 'sum' => 0];
    }

    // If the param is provided, sum its values for each year.
    if ($param && property_exists($ldObject, $param)) {
      $paramValue = intval($ldObject->$param); // Convert param value to integer
      $yearsData[$year]['sum'] += $paramValue;
    }

    // Increment the count for the year
    $yearsData[$year]['count']++;
  }

  // If param is provided, calculate the average for each year.
  if ($param) {
    foreach ($yearsData as $year => &$data) {
      $data['count'] = $data['sum'] / $data['count'];
    }
    unset($data); // Break the reference with the last element
  }

  // Only proceed if there are more than one year
  if (count($yearsData) > 1) {
    // Find the maximum count of occurrences or average for any year.
    $maxCount = max(array_column($yearsData, 'count'));

    // Get actual title
    $titleMap = [
      'duration' => 'Средняя длительность по годам',
      'quality' => 'Среднее качество по годам',
      'interest' => 'Средняя интересность по годам',
    ];
    $title = $titleMap[$param] ?? 'Количества по годам';

    // get rand class
    $rand = rand(1,99999);

    // Start outputting the HTML for the year chart.
    echo '<h5 class="year-chart-wrap-title mt-3">' . $title . ' <span class="plus">+</span><span class="minus">-</span></h5>';
    echo '<div class="year-chart-wrap">';
    echo '<div class="year-chart mb-5">';

    // Calculate the width of each bar based on the number of years.
    $width = 100 / count($yearsData);

    // Loop through each year and its count in the array.
    foreach ($yearsData as $year => $data) {
      // Round the count to the nearest integer.
      $count = round($data['count']);
      // Calculate the height of the bar as a percentage of the maximum count.
      $height = ($count / $maxCount) * 100;

      // Output the HTML for each bar with the calculated height and width.
      echo '<div class="bar" style="height: ' . $height . '%; width: ' . $width . '%">';
      // Output the year and the count inside each bar.
      echo '<span class="year">20' . $year . '</span>';
      echo '<span class="count">' . $count . '</span>';
      echo '</div>';
    }
    // Close the year chart div.
    echo '</div>';
    echo '</div>';
  }
}