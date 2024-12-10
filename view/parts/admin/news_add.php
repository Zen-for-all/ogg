<?php if (isset($news->id) && $news->id != false ) { ?>
  <form class="edit-form" data-id="<?= $news->id ?>" style="display: none;" method="POST" action="model/admin/update_news.php">
    <input type="hidden" name="id" value="<?= $news->id ?>">
    <div class="form-group d-flex justify-content-start mb-2">
      <div class="me-3" style="width: 50%;">
        <label for="title-<?= $news->id ?>">Title:</label>
        <input type="text" id="title-<?= $news->id ?>" name="title" class="form-control" value="<?= htmlspecialchars($news->title) ?>">
      </div>
      <div>
        <label for="date-<?= $news->id ?>">Date:</label>
        <input type="datetime-local" id="date-<?= $news->id ?>" name="date" class="form-control"
               value="<?= date('Y-m-d\TH:i', $news->date) ?>">
      </div>
    </div>
    <div class="form-group mb-3">
      <label for="text-<?= $news->id ?>">Text:</label>
      <textarea id="text-<?= $news->id ?>" name="text" class="form-control"><?= htmlspecialchars($news->text) ?></textarea>
    </div>
    <button type="submit" class="btn btn-outline-success me-3">Сохранить</button>
    <button type="button" class="btn btn-outline-danger cancel-btn">Отмена</button>
    <hr>
  </form>
<?php } else { ?>
  <form class="edit-form" method="POST" action="model/admin/add_news.php">
    <div class="form-group d-flex justify-content-start mb-2">
      <div class="me-3" style="width: 50%;">
        <label for="title">Title:</label>
        <input type="text" name="title" class="form-control" value="">
      </div>
      <div>
        <label for="date">Date:</label>
        <input type="datetime-local" id="date" name="date" class="form-control" value="">
      </div>
    </div>
    <div class="form-group mb-3">
      <label for="text">Text:</label>
      <textarea id="text" name="text" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-outline-success me-3">Сохранить</button>
    <button type="button" class="btn btn-outline-danger cancel-btn">Отмена</button>
    <hr>
  </form>
<?php } ?>

