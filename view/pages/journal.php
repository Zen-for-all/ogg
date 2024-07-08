<section class="container">
  <?php include 'view/parts/ld_list.php'; ?>
  <?php include 'view/parts/pagination.php'; ?>

  <div class="btn btn-success btn_show mt-4">Добавить запись</div>
  <div class="clear"></div>

  <div class="block_all mb-5 block_hide hide">
    <h2 class="mt-5">Добавить запись:</h2>
    <div class="">

      <?php
      $ldValue = $ldDate = $ldTime = $ldDuration = $locationId = $ldQuality = $ldInterest = $ldText = $ldNotice = false;
      include 'view/parts/ld_add.php';
      ?>

    </div>
  </div>

  <a class="btn btn-danger mt-3" href="/?page=ld_delete">Удалить все записи</a>
</section>