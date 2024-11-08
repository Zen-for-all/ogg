<?php
/**
 * @var object $user The user object, which contains user data such as locations.
 * @var string $title The title to be displayed on the page (usually a heading).
 * @var int $locationOnPage The number of locations to be displayed per page.
 */
?>

<h2 class="pb-5"><?= htmlspecialchars($title) ?></h2>

<div class="row">

  <?php
  // Check if the user has locations assigned
  if (!empty($user->ldlocations)) {
    $locationArray = json_decode($user->ldlocations, true);

    // Get current page and calculate the number of pages
    $pages = ceil(count($locationArray) / $locationOnPage);
    $current_page = isset($_GET['p']) ? (int)$_GET['p'] : 1;

    // Slice the array based on the current page
    $start_location = ($current_page - 1) * $locationOnPage;
    $locationArray = array_slice($locationArray, $start_location, $locationOnPage);

    foreach ($locationArray as $locationValue) {
      // Get all info about the location
      $location = new Location($locationValue);
      $locationTitle = $location->title;
      $locationText = $location->text;
      ?>

      <!-- Print info about location -->
      <div class="location_item col-md-6 mb-5">
        <div class="card px-3 py-3 h100">
          <div class="location_info show">
            <h4 class="mb-3"><?= htmlspecialchars($locationTitle) ?></h4>
            <?php if (!empty($locationText)) { ?>
              <span><b>Описание:</b></span>
              <p><?= nl2br(htmlspecialchars($locationText)) ?></p>
            <?php } ?>
          </div>

          <div class="row gx-0">
            <div class="edit_location_form mt-3">
              <h4 class="mb-3">Редактировать локацию:</h4>
              <?php include 'view/parts/note/location_add.php'; ?>
            </div>

            <!-- Button for edit location -->
            <div class="col-auto edit_location_btn show btn mt-2 mb-3 me-3">
              <span>Редактировать</span>
              <span>Отменить</span>
            </div>

            <!-- Button for delete location -->
            <div class="col-auto delete_location mt-2 show">
              <form action="model/note/delete_location.php" method="post">
                <input type="hidden" name="delete" value="<?= htmlspecialchars($locationValue) ?>">
                <input type="submit" value="Удалить" class="btn btn-outline-danger">
              </form>
            </div>
          </div>
        </div>
      </div>

      <?php
    }
  }
  ?>

</div>
