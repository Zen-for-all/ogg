<section class="container">
  <?php include 'view/parts/location_list.php'; ?>

  <div class="btn btn-outline-success btn_show mt-3 me-3">Добавить локацию</div>

  <div class="block_hide col-xl-6 hide">
    <h2 class="mt-5">Добавить локацию:</h2>
    <?php
    unset($locationValue);
    $locationValue = $locationTitle = $locationText = false;
    include 'view/parts/location_add.php';
    ?>
  </div>

  <a class="btn btn-outline-danger mt-3" href="/?page=location_delete">Удалить все локации</a>
</section>