<?php
/**
 * @var $title
 */
?>

<?php
// Check if the current user is not authorized (userId is not 1) and terminate execution if true
session_start(); // Start the session to access session variables
if ($_SESSION['userId'] != 1) {
  header("Location: 404.php"); // Redirect to the 404 page
  exit(); // Stop further script execution
}
?>

<h2 class="pb-5"><?= $title ?></h2>

<?php
// Retrieve an array of news IDs
$newsIds = getAdminNewsIds();

// Create an array of News objects
$newsArray = [];
foreach ($newsIds as $id) {
  $newsArray[] = new News($id);
}

// Render news items on the page
foreach ($newsArray as $news) {
  ?>

  <div class="wall-item mb-3">
    <div class="wall-item-header">
      <div class="wall-item-title"><b><?= htmlspecialchars($news->title) ?></b></div>
      <div class="wall-item-date small grey"><?= date('d.m.Y (H:i)', $news->date) ?></div>
    </div>

    <div class="wall-item-content"><?= htmlspecialchars($news->text) ?></div>
    <button class="col-auto edit_location_btn show btn mt-2 mb-3 me-3 edit-btn" data-id="<?= $news->id ?>">Редакировать</button>
    <hr>

    <!-- Hidden form for editing the news -->
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
  </div>

  <?php
}
?>

<script>
  // Handle edit button click
  document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', () => {
      const id = button.getAttribute('data-id');
      const form = document.querySelector(`.edit-form[data-id="${id}"]`);
      form.style.display = 'block'; // Show the form
      button.style.display = 'none'; // Hide the edit button
    });
  });

  // Handle cancel button click
  document.querySelectorAll('.cancel-btn').forEach(button => {
    button.addEventListener('click', () => {
      const form = button.closest('.edit-form');
      const id = form.getAttribute('data-id');
      const editButton = document.querySelector(`.edit-btn[data-id="${id}"]`);
      form.style.display = 'none'; // Hide the form
      editButton.style.display = 'inline-block'; // Show the edit button
    });
  });
</script>
