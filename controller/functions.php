<?php
require_once 'setting.php';
require_once 'class/User.php';
require_once 'class/Ld.php';
require_once 'class/Location.php';

// Debug function
function de($str) {
  echo "<br><br><br><br><br><br><br><pre>";
  var_dump($str);
  echo "</pre>";
  exit;
}

// Get array of Ld objects from user ID
function getLd($ldList) {
  $ldArrayObjects = [];

  if ($ldList) {
    $ldArray = json_decode($ldList, true);
    foreach ($ldArray as $ldId) {
      $ldArrayObjects[] = new Ld($ldId);
    }
  }

  return $ldArrayObjects;
}

// Get total duration
function getDuration($ldArrayObjects) {
  return array_sum(array_map(function($ld) {
    return intval($ld->duration);
  }, $ldArrayObjects));
}

// Get average duration
function getAverageDuration($ldArrayObjects) {
  $durations = array_filter(array_map(function($ld) {
    return intval($ld->duration);
  }, $ldArrayObjects));

  if (count($durations) > 0) {
    return round(array_sum($durations) / count($durations));
  }

  return null;
}

// Get average quality
function getAverageQuality($ldArrayObjects) {
  $qualities = array_filter(array_map(function($ld) {
    return intval($ld->quality);
  }, $ldArrayObjects));

  if (count($qualities) > 0) {
    return round(array_sum($qualities) / count($qualities), 1);
  }

  return null;
}

// Get average interest
function getAverageInterest($ldArrayObjects) {
  $interests = array_filter(array_map(function($ld) {
    return intval($ld->interest);
  }, $ldArrayObjects));

  if (count($interests) > 0) {
    return round(array_sum($interests) / count($interests), 1);
  }

  return null;
}

// Get the date of the last Ld
function getLastLdDate($ldArrayObjects) {
  $dates = array_map(function($ld) {
    return DateTime::createFromFormat('d.m.y', $ld->date);
  }, $ldArrayObjects);

  $maxDate = max($dates);
  return $maxDate ? $maxDate->format('d.m.y') : null;
}

// Get the number of days since the last Ld
function getIntervalLastLd($lastDate) {
  if ($lastDate) {
    $lastDate = DateTime::createFromFormat('d.m.y', $lastDate);
    $interval = (new DateTime())->diff($lastDate);
    return $interval->days;
  }

  return null;
}

// Get all Ld objects
function getAllLd() {
  global $connect;
  $result = mysqli_query($connect, "SELECT id FROM `ld`");
  $ldListObjects = [];

  while ($row = mysqli_fetch_assoc($result)) {
    $ldListObjects[] = new Ld($row['id']);
  }

  return $ldListObjects;
}

// Get the number of users
function getUserQuantity() {
  global $connect;
  $result = mysqli_query($connect, "SELECT id FROM `user`");
  return mysqli_num_rows($result);
}

// Get the longest duration
function getLongestLd($ldArrayObjects) {
  $durations = array_map(function($ld) {
    return intval($ld->duration);
  }, $ldArrayObjects);

  return round(max($durations));
}

// Get an excerpt from a text
function excerpt($text, $length) {
  if (strlen($text) <= $length) {
    return $text;
  }

  $lastSpace = strrpos(substr($text, 0, $length), ' ');

  if ($lastSpace === false) {
    return substr($text, 0, $length) . '...';
  }

  return substr($text, 0, $lastSpace) . '...';
}

// Sort Ld objects by parameter
function sortLdObjects(&$ldObjects, $parameter) {
  usort($ldObjects, function($a, $b) use ($parameter) {
    if ($parameter === 'date') {
      $dateA = DateTime::createFromFormat('d.m.y', $a->date);
      $dateB = DateTime::createFromFormat('d.m.y', $b->date);

      if ($dateA && $dateB) {
        $timestampA = $dateA->getTimestamp();
        $timestampB = $dateB->getTimestamp();

        if ($timestampA === $timestampB) {
          $timeA = DateTime::createFromFormat('H:i', $a->time);
          $timeB = DateTime::createFromFormat('H:i', $b->time);

          if ($timeA && $timeB) {
            return $timeA->getTimestamp() - $timeB->getTimestamp();
          } else {
            return 0;
          }
        }
        return $timestampA - $timestampB;
      } else {
        return 0;
      }
    }
    return (int)$a->$parameter - (int)$b->$parameter;
  });
}

// Get all information for the array of IDs
function getAllInfo($ldArray) {
  global $connect;
  $ids = implode(",", $ldArray);
  $result = mysqli_query($connect, "SELECT * FROM `ld` WHERE `id` IN ($ids)");
  $allInfoArray = [];

  while ($row = mysqli_fetch_assoc($result)) {
    $allInfoArray[] = $row;
  }

  return $allInfoArray;
}

// Get method percentages for Ld objects
function methodPercent($ldArrayObjects) {
  global $enterMethod;

  $countLdList = count($ldArrayObjects);
  $methodCounts = array_fill_keys($enterMethod, 0);

  foreach ($ldArrayObjects as $ld) {
    $method = $ld->method;

    if (isset($enterMethod[$method])) {
      $methodCounts[$enterMethod[$method]]++;
    }
  }

  $methodPercent = [];
  foreach ($methodCounts as $methodKey => $count) {
    if ($count > 0) {
      $percent = round(($count * 100 / $countLdList), 1);
      $methodPercent[$methodKey] = [$count, $percent];
    }
  }

  return $methodPercent;
}

// Print graphics for years, duration, quality, interest
function printYears($ldArrayObjects, $param = null) {
  $yearsData = [];

  foreach ($ldArrayObjects as $ldObject) {
    $year = substr($ldObject->date, 6, 2);

    if (!isset($yearsData[$year])) {
      $yearsData[$year] = ['count' => 0, 'sum' => 0];
    }

    if ($param && property_exists($ldObject, $param)) {
      $yearsData[$year]['sum'] += intval($ldObject->$param);
    }

    $yearsData[$year]['count']++;
  }

  if ($param) {
    foreach ($yearsData as $year => &$data) {
      $data['count'] = $data['sum'] / $data['count'];
    }
    unset($data);
  }

  if (count($yearsData) > 1) {
    $maxCount = max(array_column($yearsData, 'count'));

    $titleMap = [
      'duration' => 'Средняя длительность по годам',
      'quality' => 'Среднее качество по годам',
      'interest' => 'Средняя интересность по годам',
    ];
    $title = $titleMap[$param] ?? 'Количества по годам';
    $rand = rand(1,99999);

    echo '<h5 class="year-chart-wrap-title mt-3">' . $title . ' <span class="plus">+</span><span class="minus">-</span></h5>';
    echo '<div class="year-chart-wrap">';
    echo '<div class="year-chart mb-5">';
    $width = 100 / count($yearsData);

    foreach ($yearsData as $year => $data) {
      $count = round($data['count']);
      $height = ($count / $maxCount) * 100;

      echo '<div class="bar" style="height: ' . $height . '%; width: ' . $width . '%">';
      echo '<span class="year">20' . $year . '</span>';
      echo '<span class="count">' . $count . '</span>';
      echo '</div>';
    }
    echo '</div>';
    echo '</div>';
  }
}