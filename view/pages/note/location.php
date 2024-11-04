<?php include 'view/parts/note/location_list.php'; ?>

<a href="#add-location-form" class="btn btn-outline-success btn_show mt-3 me-3" id="add-location-form">Добавить локацию</a>

<div class="block_hide col-xl-6 hide">
  <h2 class="mt-5">Добавить локацию:</h2>
  <?php
  unset($locationValue);
  $locationValue = $locationTitle = $locationText = false;
  include 'view/parts/note/location_add.php';
  ?>
</div>

<a class="btn btn-outline-danger mt-3" href="/?page=location_delete">Удалить все локации</a>