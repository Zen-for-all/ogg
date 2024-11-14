<?php
// Including necessary parts
include 'view/parts/note/location_list.php';
include 'view/parts/pagination.php';

// Initializing values for the location add form
$locationValue = $locationTitle = $locationText = false;
?>

<!-- Button to open the location form -->
<a href="#add-location-form" class="btn btn-outline-success btn_show mt-3 me-3">Добавить локацию</a>

<!-- Hidden block for adding a location -->
<div class="block_hide col-xl-6 hide">
  <h2 class="mt-5">Добавить локацию:</h2>
  <?php include 'view/parts/note/location_add.php'; ?>
</div>

<!-- Button to delete all locations -->
<a class="btn btn-outline-danger mt-3" href="/location_delete">Удалить все локации</a>
