<?php
include 'view/parts/note/ld_list.php';
include 'view/parts/note/pagination.php';
?>

<a href="#add-ld-form" class="btn btn-outline-success btn_show mt-3 me-3" id="add-ld-form">Добавить запись</a>

<div class="block_all mb-5 block_hide hide">
  <h2 class="mt-5">Добавить запись:</h2>
  <div>
    <?php
    // Initialize variables with default values
    $ldValue = $ldDate = $ldTime = $ldDuration = $locationId = $ldQuality = $ldInterest = $ldText = $ldNotice = $ldPublicText = '';
    include 'view/parts/note/ld_add.php';
    ?>
  </div>
</div>

<a class="btn btn-outline-danger mt-3" href="/ld_delete">Удалить все записи</a>
