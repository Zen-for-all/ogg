<?php
/**
 * @var $user
 */
?>

<h2>ОСы</h2>
<br>

<div class="block_all">

  <?php
  if ($user->ldlist != null) {
    // get ld id's array
    $ldArray = explode(" ", trim($user->ldlist));

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

          <?php
          // print info about ld
          echo 'Дата: ' . $ldDate;
          echo '<br>';

          if ($ldTime != false) {
            echo 'Время: ' . $ldTime;
            echo '<br>';
          }

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
            echo 'Описание:<br>' . $ldText;
            echo '<br>';
          }

          if ($ldNotice != false) {
            echo '<br>';
            echo 'Заметки:<br>' . $ldNotice;
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