<?php
/**
 * @var $user
 * @var $title
 */
?>

<h2 class="pb-5"><?=$title?></h2>

<div class="row">

  <?php
  // Get locations id's array
  if ($user->ldlocations != false) {
    $locationArray = json_decode($user->ldlocations, true);

    foreach ($locationArray as $locationValue) {
      // Get all info about location
      $location = new Location($locationValue);
      $locationTitle = $location->title;
      $locationText = $location->text;
      ?>

      <!-- Print info about location -->
      <div class="location_item col-md-6 mb-5">
        <div class="card px-3 py-3 h100">
          <div class="location_info show">
            <h4 class="mb-3"><?= $locationTitle ?></h4>
            <?php if ($locationText != false) { ?>
              <span><b>Описание:</b></span>
              <p><?= $locationText ?></p>
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
                <input type="hidden" name="delete" value="<?=$locationValue?>">
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