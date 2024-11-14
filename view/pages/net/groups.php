<?php
include 'view/parts/net/group_list.php';
include 'view/parts/pagination.php';
?>

<a href="#add-group-form" class="btn btn-outline-success btn_show mt-3 me-3">Создать группу</a>

<div class="block_hide hide">
  <h2 class="mt-5">Создание группы:</h2>
  <?php
  // Initialize variables for group creation
  $groupValue = $groupTitle = $groupText = $admin = $groupDate = $userCount = $missionIdArray = $chats = $groupCity = false;
  include 'view/parts/net/group_add.php';
  ?>
</div>
