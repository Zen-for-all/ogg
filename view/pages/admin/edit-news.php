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

<h1 class="pb-5"><?= $title ?></h1>

<?php
// Retrieve an array of news IDs
$newsIds = getAdminNewsIds();

// Create an array of News objects
$newsArray = [];
foreach ($newsIds as $id) {
  $newsArray[] = new News($id);
}

// Sort news array by date in descending order
usort($newsArray, function ($a, $b) {
    return $b->date <=> $a->date; // Sort by date descending
});

// Render news items on the page
foreach ($newsArray as $news) {
  ?>
  <div class="wall-item mb-3">
    <div class="wall-item-header">
      <div class="wall-item-title"><b><?= htmlspecialchars($news->title) ?></b></div>
      <div class="wall-item-date small grey"><?= date('d.m.Y (H:i)', $news->date) ?></div>
    </div>

    <div class="wall-item-content"><?= htmlspecialchars($news->text) ?></div>
    <button class="col-auto edit_location_btn show btn mt-2 me-3 edit-btn rl" data-id="<?= $news->id ?>">Редактировать</button>

    <form action="model/admin/delete_news.php" method="post" class="rl mt-2">
      <input type="hidden" name="id" value="<?= $news->id ?>">
      <input type="submit" value="Удалить" class="btn btn-outline-danger">
    </form>
    <div class="clear"></div>
    <hr>

    <!-- Hidden form for editing the news -->
    <?php include 'view/parts/admin/news_add.php'; ?>
  </div>
  <?php
}
?>

<!-- Button to open the location form -->
<a href="#add-location-form" class="btn btn-outline-success btn_show mt-3 me-3 mb-3">Добавить новость</a>

<!-- Hidden block for adding a location -->
<div class="block_hide hide">
  <h2 class="mt-5">Добавить новость:</h2>
  <?php
  // Initializing values for the location add form
  unset($news);
  include 'view/parts/admin/news_add.php'; ?>
</div>

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
