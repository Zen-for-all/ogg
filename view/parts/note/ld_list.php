<?php
/**
 * @var object $user The current user object, containing information about the logged-in user.
 * @var int $ldOnPage The number of LD (learning data) items to display per page for pagination.
 * @var array $enterMethod An array mapping method IDs to entry methods, used for displaying entry method names.
 * @var string $hashtag_link
 */
?>

<?php include 'view/parts/search_tag.php'; ?>

<div class="container-fluid gx-0">
  <h4 class="mb-2">Сортировка:</h4>

  <div class="filters mb-4">
    <?php
    // Array of sorting criteria
    $criteria = [
      'date' => 'По дате:',
      'time' => 'По времени:',
      'duration' => 'По длительности:',
      'quality' => 'По качеству:',
      'interest' => 'По интересности:',
      'location' => 'По локации:',
      'method' => 'По входу:'
    ];

    // Loop through the criteria and generate filter blocks
    foreach ($criteria as $key => $label) { ?>
      <div class="filter border mb-2">
        <div class="rl"><?= $label ?></div>
        <a class="db rl" href="/?page=journal&sort=<?= $key ?><?= $hashtag_link ?>">+</a>
        <a class="db rl" href="/?page=journal&sort=<?= $key ?>&reverse=1<?= $hashtag_link ?>">-</a>
      </div>
    <?php } ?>
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
        if (isset($hashtag_title)) {
          $ld = new Ld($id);
          if ($ld->hashtags != false) {
            $hashtags = json_decode($ld->hashtags, true);
            $hashtag = $hashtag_title;
            if (in_array($hashtag, $hashtags)) {
              $ldObjects[] = new Ld($id);
            }
          }
        } else {
          $ldObjects[] = new Ld($id);
        }
      }

      // Check if 'sort' parameter is set and sort accordingly
      $sortCriteria = $_GET['sort'] ?? 'date';  // Use a default value of 'date' if no 'sort' parameter is provided
      $validSortCriteria = ['time', 'duration', 'location', 'quality', 'interest', 'method']; // Define valid sort criteria

      // Sort the array only if the 'sort' parameter is valid
      if (in_array($sortCriteria, $validSortCriteria)) {
        sortLdObjects($ldObjects, $sortCriteria);
      } else {
        sortLdObjects($ldObjects, 'date'); // Default sorting by 'date'
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

      // Get current LD list and calculate pagination
      $current_page = $_GET['p'] ?? 1;  // Default to page 1 if 'p' is not set
      $pages = ceil(count($ldArray) / $ldOnPage);  // Calculate total pages

      // Calculate the slice range based on the current page
      $start_ld = ($current_page - 1) * $ldOnPage;  // Calculate the starting index for the current page
      $ldArray = array_slice($ldArray, $start_ld, $ldOnPage);  // Get the current page slice of LD objects


      // print current ld list
      foreach ($ldArray as $ldValue) {
        // Get all info about ld
        $ld = new Ld($ldValue);

        // Get all info about location
        $locationTitle = false;
        if ($ld->location) {
          $location = new Location($ld->location);
          $locationId = $location->id;
          $locationTitle = $location->title;
        }

        // Get ld date
        $ldDate = $ld->date;

        // Get ld time, defaulting to false if not set
        $ldTime = ($ld->time != 0) ? $ld->time : false;

        // Get ld duration, defaulting to false if not set
        $ldDuration = ($ld->duration != 0) ? $ld->duration : false;

        // Get ld quality, defaulting to false if not set
        $ldQuality = ($ld->quality != 0) ? $ld->quality : false;

        // Get ld interest, defaulting to false if not set
        $ldInterest = ($ld->interest != 0) ? $ld->interest : false;

        // Get ld method, defaulting to false if not set
        $ldMethod = ($ld->method != 0) ? $enterMethod[$ld->method] : false;

        // Get ld text, defaulting to false if not set
        $ldText = ($ld->text != 0) ? $ld->text : false;

        // Get ld notice, defaulting to false if not set
        $ldNotice = ($ld->notice != 0) ? $ld->notice : false;

        // Get ld publish value
        $ldPublish = $ld->publish;

        // Get hashtags, defaulting to false if not set
        $hashtags = !empty($ld->hashtags) ? json_decode($ld->hashtags, true) : false;
        ?>

        <div class="col-xxl-3 col-lg-3 col-md-6 mb-5">
          <div class="card px-3 py-3 h100">
            <h5 class="mb-3"><?=$ldDate?> <?php if ($ldTime) { echo '(' . $ldTime . ')'; } ?></h5>

            <?php if ($ldDuration) { ?>
              <span>Длительность: <b><?=$ldDuration?> сек</b></span>
            <?php } ?>

            <?php if ($locationTitle) { ?>
              <span>Локация: <b><?=$locationTitle?></b></span>
            <?php } ?>

            <?php if ($ldQuality) { ?>
              <span>Качество: <b><?=$ldQuality?></b></span>
            <?php } ?>

            <?php if ($ldInterest) { ?>
              <span>Интерес: <b><?=$ldInterest?></b></span>
            <?php } ?>

            <?php if ($ldMethod) { ?>
              <span>Метод входа: <b><?=$ldMethod?></b></span><br>
            <?php } ?>

            <?php if ($ldText) { ?>
              <span><b>Описание:</b> <?=excerpt($ldText, 300)?></span><br>
            <?php } ?>

            <?php if ($ldNotice) { ?>
              <span><b>Заметки:</b> <?=excerpt($ldNotice, 200)?></span><br>
            <?php } ?>

            <?php if (!empty($hashtags)) { ?>
              <span><b>Теги:</b></span>
              <div>
                <?php
                foreach ($hashtags as $hashtag) {
                  echo '<a href="/?page=journal&hashtag=' . $hashtag . '">#' . $hashtag . '</a> | ';
                }
                echo '<br><br>';
                ?>
              </div>
            <?php } ?>

            <?php if ($ldPublish == 1) { ?>
              <span><?='Опубликовано'?></span>
            <?php } ?>

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
