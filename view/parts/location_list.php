<h2>Локации</h2>
<br>

<div class="block_all">

  <?php
  // get locations id's array
  $locationArray = explode(" ", trim($user->ldlocations));

  foreach ($locationArray as $locationValue) {
    // get all info about location
    $location = new Location($locationValue);
    $locationTitle = $location->title;
    $locationText = $location->text;
    ?>

    <!--print info about location-->
    <div class="block_all location_item">
      <div class="block_all location_info show">
        <p><?= $locationTitle ?></p>
        <?php if ($locationText != false) { ?>
          <br>
          <p>Описание:</p>
          <p><?= $locationText ?></p>
        <?php } ?>
      </div>

      <div class="block_all edit_location_form hide">
        <h2>Редактировать локацию:</h2>

        <?php include 'location_add.php'; ?>

      </div>

      <div class="clear pT20"></div>

      <!-- button for edit ld -->
      <div class="btn edit_location_btn">
        <span class="show">Редактировать</span>
        <span class="hide">Отменить</span>
      </div>

      <!-- button for delete location -->
      <div class="delete_location show">
        <form action="../../model/delete_location.php" method="post">
          <input type="hidden" name="delete" value="<?=$locationValue?>">
          <input type="submit" value="Удалить" class="btn">
        </form>
      </div>
      <div class="clear"></div>
    </div>

    <?php
  }
  ?>

</div>
