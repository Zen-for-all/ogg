<?php
/**
 * @var int $ldOnPage The number of LD (learning data) items to display per page for pagination.
 * @var array $enterMethod An array mapping method IDs to entry methods, used for displaying entry method names.
 */
?>

<?php
// Check if either 'hashtag' or 'search' is set and assign their values
if (!empty($_GET['hashtag'])) {
  $hashtag_title = $_GET['hashtag'];
} elseif (!empty($_GET['search'])) {
  $hashtag_title = $_GET['search'];
}

// Generate hashtag link if hashtag title is set
$hashtag_link = isset($hashtag_title) ? '&hashtag=' . urlencode($hashtag_title) : '';
?>

<div class="row">
  <div class="col-md-6">
    <p>Найти по тегу</p>
    <form action="/posts" method="get">
      <input type="text" class="form-control no_space" name="search" value="<?= isset($hashtag_title) ? htmlspecialchars($hashtag_title) : '' ?>">
      <input type="submit" value="Искать" class="btn btn-outline-success btn_show mt-3">
    </form>
  </div>
</div>
<br><br>

<?php if (!empty($hashtag_title)) { ?>
  <h3>#<?= htmlspecialchars($hashtag_title) ?> <a href="/posts">(x)</a></h3><br>
<?php } ?>

<div class="container-fluid gx-0">
  <h4 class="mb-2">Сортировка:</h4>

  <div class="filters mb-4">
    <?php
    // Array of sorting criteria
    $criteria = [
      'date' => 'По дате:',
      'duration' => 'По длительности:',
      'quality' => 'По качеству:',
      'interest' => 'По интересности:',
      'method' => 'По входу:'
    ];

    // Loop through the criteria and generate filter blocks
    foreach ($criteria as $key => $label) { ?>
      <div class="filter border mb-2">
        <div class="rl"><?= $label ?></div>
        <a class="db rl" href="/?page=posts&sort=<?= $key ?><?= $hashtag_link ?>">+</a>
        <a class="db rl" href="/?page=posts&sort=<?= $key ?>&reverse=1<?= $hashtag_link ?>">-</a>
      </div>
    <?php } ?>
  </div>

  <div class="row">

    <?php
    // Get IDs public lds
    $ldArray = getPublicLd();

    if (!empty($ldArray)) {
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
      $validSortCriteria = ['time', 'duration', 'quality', 'interest', 'method']; // Define valid sort criteria

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

        // Get author name
        $author = new User($ld->user);

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

        // Get ld public text, defaulting to false if not set
        $ldPublicText = ($ld->public_text != 0) ? $ld->public_text : false;

        // Get hashtags, defaulting to false if not set
        $hashtags = !empty($ld->hashtags) ? json_decode($ld->hashtags, true) : false;

        // likes
        $likes = ($ld->likes != 0) ? $ld->likes : false;
        if (is_string($likes) && !empty($likes)) {
          $likes = json_decode($likes, true);
        }
        if (!is_array($likes)) {
          $likes = [];
        }

        // views
        $views = ($ld->views != 0) ? $ld->views : false;
        if (is_string($views) && !empty($views)) {
          $views = json_decode($views, true);
        }
        if (!is_array($views)) {
          $views = [];
        }
        ?>

        <div class="col-xxl-3 col-lg-3 col-md-6 mb-5">
          <div class="card px-3 py-3 h100">
            <h5 class="mb-3"><?=$ldDate?> <?php if ($ldTime) { echo '(' . $ldTime . ')'; } ?></h5>

            <?php if ($ldDuration) { ?>
              <div>Длительность: <b><?=$ldDuration?></b></div>
            <?php } ?>

            <?php if ($ldQuality) { ?>
              <div>Качество: <b><?=$ldQuality?></b></div>
            <?php } ?>

            <?php if ($ldInterest) { ?>
              <div>Интерес: <b><?=$ldInterest?></b></div>
            <?php } ?>

            <?php if ($ldMethod) { ?>
              <div>Метод входа: <b><?=$ldMethod?></b></div><br>
            <?php } ?>

            <?php if ($ldPublicText) { ?>
              <div><b>Описание:</b> <?=html_entity_decode(excerpt($ldPublicText, 300))?></div><br>
            <?php } ?>

            <?php if (!empty($hashtags)) { ?>
              <div><b>Теги:</b></div>
              <div>
                <?php
                foreach ($hashtags as $hashtag) {
                  echo '<a href="/?page=posts&hashtag=' . $hashtag . '">#' . $hashtag . '</a> | ';
                }
                echo '<br><br>';
                ?>
              </div>
            <?php } ?>

            <div>Автор: <b><a href="/?page=profile&id=<?=$author->id?>"><?=$author->login?></a></b></div>
            <br>

            <div class="button-container">
              <!-- Like icon -->
              <div class="rl icon-count-block">
                <div class="rl icon-img">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                  </svg>
                </div>

                <div class="rl icon-count">
                  <?php echo count($likes); ?>
                </div>
              </div>

              <!-- Views -->
              <div class="rl icon-count-block">
                <div class="rl icon-img">
                  <svg enable-background="new 0 0 32 32" id="Editable-line" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="  M16,7C9.934,7,4.798,10.776,3,16c1.798,5.224,6.934,9,13,9s11.202-3.776,13-9C27.202,10.776,22.066,7,16,7z" fill="none" id="XMLID_10_" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/><circle cx="16" cy="16" fill="none" id="XMLID_12_" r="5" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/></svg>
                </div>

                <div class="rl icon-count">
                  <?php echo count($views); ?>
                </div>
              </div>
            </div>

            <a class="btn btn-outline-secondary mt-4 mb-3" href="/?page=post&id=<?=$ld->id?>">Подробнее</a>
          </div>
        </div>

        <?php
      }

      unset($ldValue);
    }
    ?>

  </div>
</div>
