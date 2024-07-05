<section class="container">
  <?php include 'view/parts/ld_list.php'; ?>
  <?php include 'view/parts/pagination.php'; ?>

  <div class="btn btn-light btn_show">+ Добавить запись</div>
  <div class="clear"></div>

  <div class="block_all block_hide hide">
    <h2>Добавить запись:</h2>
    <?php
    $ldValue = $ldDate = $ldTime = $ldDuration = $locationId = $ldQuality = $ldInterest = $ldText = $ldNotice = false;
    include 'view/parts/ld_add.php';
    ?>
  </div>
  <br>
  <a href="/?page=ld_delete">Удалить все записи</a>
</section>