<?php
/**
 * @var $user
 */
?>

<h2 class="mb-3"><?= htmlspecialchars($user->login) ?></h2>

<a href="/settings-net">К настройкам социального аккаунта</a>

<p class="mb-5">В проекте с <?= htmlspecialchars($user->date) ?></p>

<div class="row mb-3">
  <!-- Including user information editing section -->
  <?php include 'view/parts/note/edit_user_info.php'; ?>

  <div class="col-md-6">
    <!-- Including import functionality -->
    <?php include 'view/parts/note/import_ld.php'; ?>
  </div>

  <div class="col-md-6">
    <!-- Including export functionality -->
    <?php include 'view/parts/note/export_ld.php'; ?>
  </div>
</div>

<div class="row mb-3">
  <div class="col">
    <a class="btn btn-outline-secondary" href="controller/logout.php">Выйти</a>
  </div>
  <div class="col">
    <a class="btn btn-outline-danger" href="/user_delete">Удалить акаунт</a>
  </div>
</div>
