<?php
/**
 * @var $user
 */

//
if ($user->ldlist) {
  $ldArrayObjects = getLd($user->ldlist);
  $quantityLd = count($ldArrayObjects);
}

?>

<section class="container">
  <div class="row mb-5">
    <h1><?= $user->login ?></h1>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="avatar">
        ava
      </div>

    </div>

    <div class="col-md-6">
      <p>Всего ОСов: <b><?= $quantityLd ?? 0 ?></b></p>
    </div>
  </div>
</section>
