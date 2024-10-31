<?php
/**
 * @var $user
 * @var $title
 * @var $ld_on_page
 */
?>

<?php
if (isset($_GET['hashtag'])) {
  $hashtag_link = '&hashtag=' . $_GET['hashtag'];
} else {
  $hashtag_link = '';
}
?>

<h2 class="pb-5"><?=$title?></h2>

<?php if (isset($_GET['hashtag'])) { ?>
  <h3>#<?=$_GET['hashtag']?> <a href="/?page=journal">(x)</a></h3><br>
<?php } ?>

<div class="container-fluid gx-0">
  <h4 class="mb-2">Сортировка:</h4>

  <div class="filters mb-4">
    <div class="filter border mb-2">
      <div class="rl">По дате:</div>
      <a class="db rl" href="/?page=journal&sort=date<?=$hashtag_link?>">+</a>
      <a class="db rl" href="/?page=journal&sort=date&reverse=1<?=$hashtag_link?>">-</a>
    </div>

    <div class="filter border mb-2">
      <div class="rl">По времени:</div>
      <a class="db rl" href="/?page=journal&sort=time<?=$hashtag_link?>">+</a>
      <a class="db rl" href="/?page=journal&sort=time&reverse=1<?=$hashtag_link?>">-</a>
    </div>

    <div class="filter border mb-2">
      <div class="rl">По длительности:</div>
      <a class="db rl" href="/?page=journal&sort=duration<?=$hashtag_link?>">+</a>
      <a class="db rl" href="/?page=journal&sort=duration&reverse=1<?=$hashtag_link?>">-</a>
    </div>

    <div class="filter border mb-2">
      <div class="rl">По качеству:</div>
      <a class="db rl" href="/?page=journal&sort=quality<?=$hashtag_link?>">+</a>
      <a class="db rl" href="/?page=journal&sort=quality&reverse=1<?=$hashtag_link?>">-</a>
    </div>

    <div class="filter border mb-2">
      <div class="rl">По интересности:</div>
      <a class="db rl" href="/?page=journal&sort=interest<?=$hashtag_link?>">+</a>
      <a class="db rl" href="/?page=journal&sort=interest&reverse=1<?=$hashtag_link?>">-</a>
    </div>

    <div class="filter border mb-2">
      <div class="rl">По локации:</div>
      <a class="db rl" href="/?page=journal&sort=location<?=$hashtag_link?>">+</a>
      <a class="db rl" href="/?page=journal&sort=location&reverse=1<?=$hashtag_link?>">-</a>
    </div>

    <div class="filter border mb-2">
      <div class="rl">По входу:</div>
      <a class="db rl" href="/?page=journal&sort=method<?=$hashtag_link?>">+</a>
      <a class="db rl" href="/?page=journal&sort=method&reverse=1<?=$hashtag_link?>">-</a>
    </div>
  </div>

  <div class="row">

    <?php
    if ($user->ldlist != null) {
      // get ld id's array
      $ldArray = json_decode($user->ldlist, true);

      // Get all the information for the provided IDs
      $allInfoArray = getAllInfo($ldArray);

      // Initialize an array to hold Ld objects
      $ldObjects = [];

      // Create Ld objects and fill them with the fetched information
      foreach ($ldArray as $id) {
        // Add the Ld object to the array
        if (isset($_GET['hashtag'])) {
          $ld = new Ld($id);
          if ($ld->hashtags != false) {
            $hashtags = json_decode($ld->hashtags, true);
            $hashtag = $_GET['hashtag'];
            if (in_array($hashtag, $hashtags)) {
              $ldObjects[] = new Ld($id);
            }
          }
        } else {
          $ldObjects[] = new Ld($id);
        }
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

        $ldPublish = $ld->publish;

        if (!empty($ld->hashtags)) {
          $hashtags = json_decode($ld->hashtags, true);
        } else {
          $hashtags = false;
        }
        ?>

        <div class="col-xxl-3 col-lg-4 col-md-6 mb-5">
          <div class="card px-3 py-3 h100">
            <h5 class="mb-3"><?=$ldDate?> <?php if ($ldTime) { echo '(' . $ldTime . ')'; } ?></h5>

            <?php if ($ldDuration != false) { ?>
              <span>Длительность: <b><?=$ldDuration?></b></span>
            <? } ?>

            <?php if ($locationTitle != false) { ?>
              <span>Локация: <b><?=$locationTitle?></b></span>
            <? } ?>

            <?php if ($ldQuality != false) { ?>
              <span>Качество: <b><?=$ldQuality?></b></span>
            <? } ?>

            <?php if ($ldInterest != false) { ?>
              <span>Интерес: <b><?=$ldInterest?></b></span>
            <? } ?>

            <?php if ($ldMethod != false) { ?>
              <span>Метод входа: <b><?=$ldMethod?></b></span><br>
            <? } ?>

            <?php if ($ldText != false) { ?>
              <span><b>Описание:</b> <?=excerpt($ldText, 300)?></span><br>
            <? } ?>

            <?php if ($ldNotice != false) { ?>
              <span><b>Заметки:</b> <?=excerpt($ldNotice, 200)?></span><br>
            <? } ?>

            <?php if (!empty($hashtags)) { ?>
              <span><b>Хэштеги:</b></span>
              <div>
                <?php
                foreach ($hashtags as $hashtag) {
                  echo '<a href="/?page=journal&hashtag=' . $hashtag . '">#' . $hashtag . '</a> | ';
                }
                echo '<br><br>';
                ?>
              </div>
            <? } ?>

            <?php if ($ldPublish == 1) { ?>
              <span><?='Опубликовано'?></span>
            <? } ?>

            <a class="btn btn-outline-secondary mt-4 mb-3" href="/?page=ld&id=<?=$ld->id?>">Подробнее</a>
          </div>
        </div>

        <?php
      }

      unset($ldValue);
    }
    ?>

  </div>

</div>