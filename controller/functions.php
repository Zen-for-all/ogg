<?php
require_once 'setting.php';
require_once 'class/User.php';
require_once 'class/Ld.php';
require_once 'class/Location.php';
require_once 'class/Group.php';
require_once 'class/News.php';

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
    if (empty($ldArrayObjects)) {
        return null;
    }

    $sum = 0;
    $count = 0;

    foreach ($ldArrayObjects as $ld) {
        $duration = (int)$ld->duration;
        if ($duration > 0) {
            $sum += $duration;
            $count++;
        }
    }

    return $count > 0 ? round($sum / $count) : null;
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

// Get all Groups sorted by the number of users and filtered by mission IDs
function getAllGroups($missionIds = []) {
  global $connect;

  // Check if the array of mission IDs is not empty
  if (!empty($missionIds)) {
    // Prepare the JSON format of mission IDs for the SQL query
    $missionIdsJson = json_encode($missionIds);

    // SQL query to get groups ordered by the number of users, where all mission IDs are present in the "mission" field
    $query = "
      SELECT id 
      FROM `groups`
      WHERE JSON_CONTAINS(mission, '$missionIdsJson')
      ORDER BY JSON_LENGTH(users) DESC
    ";
  } else {
    // If missionIds is empty, get all groups without filtering by mission
    $query = "
      SELECT id 
      FROM `groups`
      ORDER BY JSON_LENGTH(users) DESC
    ";
  }

  // Execute the query
  $result = mysqli_query($connect, $query);

  // Map the result to create Group objects
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

// Get all Users filtered by mission IDs
function getAllUsers($missionIds = []) {
  global $connect;

  // Check if the array of mission IDs is not empty
  if (!empty($missionIds)) {
    // Prepare the JSON format of mission IDs for the SQL query
    $missionIdsJson = json_encode($missionIds);

    // SQL query to get users where all mission IDs are present in the "mission" field
    $query = "
      SELECT id 
      FROM `user`
      WHERE JSON_CONTAINS(mission, '$missionIdsJson')
    ";
  } else {
    // If missionIds is empty, get all users without filtering by mission
    $query = "
      SELECT id 
      FROM `user`
    ";
  }

  // Execute the query
  $result = mysqli_query($connect, $query);

  // Map the result to create User objects
  return array_map(fn($row) => new User($row['id']), mysqli_fetch_all($result, MYSQLI_ASSOC));
}

// Get all Users filtered by mission IDs and public parameter (anonym = 0)
function getAllPublicUsers($missionIds = []) {
  global $connect;

  // Base SQL query with public parameter check
  $query = "SELECT id FROM `user`WHERE anonym = 0";

  // Check if the array of mission IDs is not empty
  if (!empty($missionIds)) {
    // Prepare the JSON format of mission IDs for the SQL query
    $missionIdsJson = json_encode($missionIds);

    // Add filtering by mission IDs to the query
    $query .= " AND JSON_CONTAINS(mission, '$missionIdsJson')";
  }

  // Execute the query
  $result = mysqli_query($connect, $query);

  // Map the result to create User objects
  return array_map(fn($row) => new User($row['id']), mysqli_fetch_all($result, MYSQLI_ASSOC));
}


// This function retrieves all news IDs from the 'news' table.
function getAllNewsIds() {
  global $connect;
  $ids = [];
  $query = "SELECT `id` FROM `news`";
  $result = mysqli_query($connect, $query);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $ids[] = (int) $row['id'];
    }
  }

  return $ids;
}

// This function retrieves news IDs from the 'news' table where the 'admin' field is not null.
function getAdminNewsIds() {
  global $connect;
  $ids = [];
  $query = "SELECT `id` FROM `news` WHERE `admin` IS NOT NULL";
  $result = mysqli_query($connect, $query);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $ids[] = (int) $row['id'];
    }
  }

  return $ids;
}

// Get IDs public lds
function getPublicLd() {
  global $connect;
  $ids = [];
  $query = "SELECT `id` FROM `ld` WHERE publish = 1";
  $result = mysqli_query($connect, $query);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $ids[] = (int) $row['id'];
    }
  }

  return $ids;
}

// Get public lds from given IDs
function getPublicLdFromArray(array $ids) {
  global $connect;
  $publicIds = [];

  if (empty($ids)) {
    return $publicIds;
  }

  // Sanitize input and create a comma-separated list of integers
  $idsList = implode(',', array_map('intval', $ids));

  $query = "SELECT `id` FROM `ld` WHERE publish = 1 AND `id` IN ($idsList)";
  $result = mysqli_query($connect, $query);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $publicIds[] = (int) $row['id'];
    }
  }

  return $publicIds;
}
