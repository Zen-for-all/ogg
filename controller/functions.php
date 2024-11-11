<?php
require_once 'setting.php';
require_once 'class/User.php';
require_once 'class/Ld.php';
require_once 'class/Location.php';
require_once 'class/Group.php';

// Debug function
function de($str) {
  echo "<br><br><br><br><br><br><br><pre>";
  var_dump($str);
  echo "</pre>";
  exit;
}

// Get array of Ld objects from user ID
function getLd($ldList) {
  if (!$ldList) return [];
  $ldArray = json_decode($ldList, true);
  return array_map(fn($ldId) => new Ld($ldId), $ldArray);
}

// Get total duration
function getDuration($ldArrayObjects) {
  return array_sum(array_map(fn($ld) => (int)$ld->duration, $ldArrayObjects));
}

// Get average duration
function getAverageDuration($ldArrayObjects) {
  $durations = array_map(fn($ld) => (int)$ld->duration, $ldArrayObjects);
  $filteredDurations = array_filter($durations);

  if ($filteredDurations) {
    return round(array_sum($filteredDurations) / count($filteredDurations));
  }
  return null;
}

// Get average quality
function getAverageQuality($ldArrayObjects) {
  $qualities = array_map(fn($ld) => (int)$ld->quality, $ldArrayObjects);
  $filteredQualities = array_filter($qualities);

  if ($filteredQualities) {
    return round(array_sum($filteredQualities) / count($filteredQualities), 1);
  }
  return null;
}

// Get average interest
function getAverageInterest($ldArrayObjects) {
  $interests = array_map(fn($ld) => (int)$ld->interest, $ldArrayObjects);
  $filteredInterests = array_filter($interests);

  if ($filteredInterests) {
    return round(array_sum($filteredInterests) / count($filteredInterests), 1);
  }
  return null;
}

// Get the date of the last Ld
function getLastLdDate($ldArrayObjects) {
  $dates = array_map(fn($ld) => DateTime::createFromFormat('d.m.y', $ld->date), $ldArrayObjects);
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
  return array_map(fn($row) => new Ld($row['id']), mysqli_fetch_all($result, MYSQLI_ASSOC));
}

// Get all Groups
function getAllGroups() {
  global $connect;
  $result = mysqli_query($connect, "SELECT id FROM `groups`");
  return array_map(fn($row) => new Group($row['id']), mysqli_fetch_all($result, MYSQLI_ASSOC));
}

// Get the number of users
function getUserQuantity() {
  global $connect;
  $result = mysqli_query($connect, "SELECT id FROM `user`");
  return mysqli_num_rows($result);
}

// Get the longest duration
function getLongestLd($ldArrayObjects) {
  return round(max(array_map(fn($ld) => (int)$ld->duration, $ldArrayObjects)));
}

// Get an excerpt from a text
function excerpt($text, $length) {
  if (strlen($text) <= $length) return $text;

  $lastSpace = strrpos(substr($text, 0, $length), ' ');
  return $lastSpace === false ? substr($text, 0, $length) . '...' : substr($text, 0, $lastSpace) . '...';
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
        return $timestampA !== $timestampB ? $timestampA - $timestampB : compareTime($a, $b);
      }
      return 0;
    }
    return (int)$a->$parameter - (int)$b->$parameter;
  });
}

//
function compareTime($a, $b) {
  $timeA = DateTime::createFromFormat('H:i', $a->time);
  $timeB = DateTime::createFromFormat('H:i', $b->time);
  return $timeA && $timeB ? $timeA->getTimestamp() - $timeB->getTimestamp() : 0;
}

// Get all information for the array of IDs
function getAllInfo($ldArray) {
    global $connect;
    $ids = implode(",", $ldArray);
    $result = mysqli_query($connect, "SELECT * FROM `ld` WHERE `id` IN ($ids)");
    return mysqli_fetch_all($result, MYSQLI_ASSOC); // Directly return all data as an array
}

// Get method percentages for Ld objects
function methodPercent($ldArrayObjects) {
    global $enterMethod;

    $countLdList = count($ldArrayObjects);
    $methodCounts = array_fill_keys($enterMethod, 0);

    foreach ($ldArrayObjects as $ld) {
        if (isset($enterMethod[$ld->method])) {
            $methodCounts[$enterMethod[$ld->method]]++;
        }
    }

    return array_map(function($count) use ($countLdList) {
        $percent = round(($count * 100 / $countLdList), 1);
        return [$count, $percent];
    }, $methodCounts);
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

    // Calculate average if parameter is given
    if ($param) {
        $yearsData = array_map(function($data) {
            $data['count'] = $data['sum'] / $data['count'];
            return $data;
        }, $yearsData);
    }

    if (count($yearsData) > 1) {
        $maxCount = max(array_column($yearsData, 'count'));
        $titleMap = [
            'duration' => 'Средняя длительность по годам',
            'quality' => 'Среднее качество по годам',
            'interest' => 'Средняя интересность по годам',
        ];
        $title = $titleMap[$param] ?? 'Количества по годам';
        $rand = rand(1, 99999);

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

// Print confirmation page
function printConfirmationPage($title, $modelFile) {
  echo '
  <h3 class="mb-5">' . $title . '</h3>
<div class="d-flex">
  <a class="btn btn-outline-secondary me-3" href="' . $modelFile . '">Подтверждаю</a>
  <a class="btn btn-outline-secondary" href="javascript:history.back()">Отменить</a>
</div>
  ';
}

?>
