<?php
/**
 * @var $user
 */
?>

<h2>ОСы</h2>
<br>

<div class="block_all">
  <h3>Сортировка:</h3>
  <a href="/?page=journal&sort=date">Дата +-</a><br>
  <a href="/?page=journal&sort=date&reverse=1">Дата -+</a><br>
  <a href="/?page=journal&sort=time">Время +-</a><br>
  <a href="/?page=journal&sort=time&reverse=1">Время -+</a><br>
  <a href="/?page=journal&sort=duration">Длительность +-</a><br>
  <a href="/?page=journal&sort=duration&reverse=1">Длительность -+</a><br>
  <a href="/?page=journal&sort=location">Локации +-</a><br>
  <a href="/?page=journal&sort=location&reverse=1">Локации -+</a><br>
  <a href="/?page=journal&sort=quality">Качество +-</a><br>
  <a href="/?page=journal&sort=quality&reverse=1">Качество -+</a><br>
  <a href="/?page=journal&sort=interest">Интересность +-</a><br>
  <a href="/?page=journal&sort=interest&reverse=1">Интересность -+</a><br>
  <a href="/?page=journal&sort=method">Метод входа +-</a><br>
  <a href="/?page=journal&sort=method&reverse=1">Метод входа -+</a><br>
  <br>
  <hr>
  <br>

  <?php
  if ($user->ldlist != null) {
    // get ld id's array
    $ldArray = explode(" ", trim($user->ldlist));

    // Get all the information for the provided IDs
    $allInfoArray = getAllInfo($ldArray);

    // Initialize an array to hold Ld objects
    $ldObjects = [];
    // Create Ld objects and fill them with the fetched information
    foreach ($ldArray as $id) {
      $ld = new Ld($id);
      // Fill the Ld object with the corresponding data
      $ld->getInfo($allInfoArray[$id]);
      // Add the Ld object to the array
      $ldObjects[] = $ld;
    }

    // Sort the array of Ld objects by attribute
    if (isset($_GET['sort']) && $_GET['sort'] === 'time') {
      sortLdObjects($ldObjects, 'time');
    } elseif (isset($_GET['sort']) && $_GET['sort'] === 'duration') {
      sortLdObjects($ldObjects, 'duration');
    } elseif (isset($_GET['sort']) && $_GET['sort'] === 'location') {
      sortLdObjects($ldObjects, 'location');
    } elseif (isset($_GET['sort']) && $_GET['sort'] === 'quality') {
      sortLdObjects($ldObjects, 'quality');
    } elseif (isset($_GET['sort']) && $_GET['sort'] === 'interest') {
      sortLdObjects($ldObjects, 'interest');
    } elseif (isset($_GET['sort']) && $_GET['sort'] === 'method') {
      sortLdObjects($ldObjects, 'method');
    } else {
      sortLdObjects($ldObjects, 'date');
    }

    // Map the sorted array of Ld objects to an array of their IDs
    $ldArray = array_map(function($ld) {
      return $ld->id;
    }, $ldObjects);

    $ldArray = array_reverse($ldArray);

    // sort reverse
    if (isset($_GET['reverse']) && $_GET['reverse'] === '1') {
      $ldArray = array_reverse($ldArray);
    }

    // get current ld list
    $pages = ceil(count($ldArray) / $ld_on_page);
    if (isset($_GET['p'])) {
      $current_page = $_GET['p'];
    } else {
      $current_page = 1;
    }

    if (!isset($_GET['p']) || $_GET['p'] === 1) {
      $ldArray = array_slice($ldArray, 0, $ld_on_page);
    } else {
      $start_ld = $current_page * $ld_on_page - $ld_on_page;
      $ldArray = array_slice($ldArray, $start_ld, $ld_on_page);
    }

    // print current ld list
    foreach ($ldArray as $ldValue) {
      // get all info about ld
      $ld = new Ld($ldValue);

      // get all info about location
      if ($ld->location != false) {
        $location = new Location($ld->location);
        $locationId = $location->id;
        $locationTitle = $location->title;
      } else {
        $locationTitle = false;
      }

      $ldDate = $ld->date;

      if ($ld->time != 0) {
        $ldTime = $ld->time;
      } else {
        $ldTime = false;
      }

      if ($ld->duration != 0) {
        $ldDuration = $ld->duration;
      } else {
        $ldDuration = false;
      }

      if ($ld->quality != 0) {
        $ldQuality = $ld->quality;
      } else {
        $ldQuality = false;
      }

      if ($ld->interest != 0) {
        $ldInterest = $ld->interest;
      } else {
        $ldInterest = false;
      }

      if ($ld->method != 0) {
        $ldMethod = $enterMethod[$ld->method];
      } else {
        $ldMethod = false;
      }

      if ($ld->text != 0) {
        $ldText = $ld->text;
      } else {
        $ldText = false;
      }

      if ($ld->notice != 0) {
        $ldNotice = $ld->notice;
      } else {
        $ldNotice = false;
      }
      ?>

      <div class="block_all ld_item">
        <div class="block_all ld_info show">
          <a href="/?page=ld&id=<?=$ld->id?>">
            <?php
            // print info about ld
            echo $ldDate;

            if ($ldTime != false) {
              echo ' (' . $ldTime . ')';
            }
            ?>
          </a>
          <br>

          <?php
          if ($ldDuration != false) {
            echo 'Длительность: ' . $ldDuration;
            echo '<br>';
          }

          if ($locationTitle != false) {
            echo 'Локация: ' . $locationTitle;
            echo '<br>';
          }

          if ($ldQuality != false) {
            echo 'Качество: ' . $ldQuality;
            echo '<br>';
          }

          if ($ldInterest != false) {
            echo 'Интерес: ' . $ldInterest;
            echo '<br>';
          }

          if ($ldMethod != false) {
            echo 'Метод входа: ' . $ldMethod;
            echo '<br>';
          }

          if ($ldText != false) {
            echo '<br>';
            echo 'Описание:<br>';
            echo excerpt($ldText, 300);
            echo '<br>';
          }

          if ($ldNotice != false) {
            echo '<br>';
            echo 'Заметки:<br>';
            echo excerpt($ldNotice, 200);
            echo '<br>';
          }
          ?>

        </div>

        <div class="block_all edit_ld_form hide">
          <h2>Редактировать запись:</h2>

          <?php include 'ld_add.php'; ?>

        </div>

        <div class="clear pT20"></div>

        <!-- button for edit ld -->
        <div class="btn edit_ld_btn show">
          <span class="show">Редактировать</span>
          <span class="hide">Отменить</span>
        </div>

        <!-- button for delete ld -->
        <div class="delete_ld show">
          <form action="../../model/delete_ld.php" method="post">
            <input type="hidden" name="delete" value="<?=$ldValue?>">
            <input type="submit" value="Удалить" class="btn">
          </form>
        </div>
        <div class="clear"></div>
      </div>
      <div class="pT20"></div>

      <?php
    }

    unset($ldValue);
  }
  ?>

</div>