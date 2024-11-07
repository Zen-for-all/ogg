<?php include 'view/parts/net/group_list.php'; ?>
<?php include 'view/parts/note/pagination.php'; ?>

<a href="#add-group-form" class="btn btn-outline-success btn_show mt-3 me-3">Создать группу</a>

<div class="block_hide col-xl-6 hide">
  <h2 class="mt-5">Создание группы:</h2>
  <?php
  $groupValue = $groupTitle = $groupText = $admin = $groupDate = $userCount = $MissionIdArray = $Chats = false;
  include 'view/parts/net/group_add.php';
  ?>
</div>
