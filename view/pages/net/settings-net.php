<?php
/**
 * @var $user
 */
?>

<h1 class="mb-5"><?= htmlspecialchars($user->login) ?></h1>

<a href="/settings">К настройкам дневника</a>

<p class="mb-5">В проекте с <?= htmlspecialchars($user->date) ?></p>

<div class="row mb-3">
  <!-- Including user net information editing section -->
  <?php include 'view/parts/net/edit_user_net_info.php'; ?>
</div>

<div class="row mb-3">
  <div class="col">
    <a class="btn btn-outline-secondary" href="controller/logout.php">Выйти</a>
  </div>
  <div class="col">
    <a class="btn btn-outline-danger" href="/user_delete">Удалить акаунт</a>
  </div>
</div>
