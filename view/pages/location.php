<section class="block">
  <?php include 'view/parts/location_list.php'; ?>
</section>
<div class="clear"></div>

<div class="block">
  <div class="btn btn_show">+ Добавить локацию</div>
  <div class="clear"></div>

  <div class="block_all block_hide hide">
    <h2>Добавить локацию:</h2>
    <?php
    unset($locationValue);
    $locationValue = $locationTitle = $locationText = false;
    include 'view/parts/location_add.php';
    ?>
  </div>
  <br>
  <a href="/?page=location_delete">Удалить все локации</a>
</div>
<div class="clear"></div>