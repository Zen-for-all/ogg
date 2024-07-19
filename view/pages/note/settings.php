<section class="container">
  <h2 class="mb-3"><?=$user->login?></h2>

  <p class="mb-5">В проекте с <?=$user->date?></p>

  <div class="row mb-3">
    <?php include 'view/parts/note/edit_user_info.php'; ?>

    <div class="col-md-6">
      <?php include 'view/parts/note/import_ld.php'; ?>
    </div>

    <div class="col-md-6">
      <?php include 'view/parts/note/export_ld.php'; ?>
    </div>
  </div>
</section>