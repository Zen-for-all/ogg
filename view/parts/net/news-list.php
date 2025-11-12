<div class="wall mt-5">
  <div class="wall-title"><b>News</b></div>
  <hr>

  <?php
  // Retrieve an array of news IDs
  $newsIds = getAllNewsIds();

  // Create an array of News objects
  $newsArray = [];
  foreach ($newsIds as $id) {
    $newsArray[] = new News($id);
  }

  // Sort news array by date in descending order
  usort($newsArray, function ($a, $b) {
    return $b->date <=> $a->date; // Sort by date descending
  });

  // Limit the array to 10 items
  $newsArray = array_slice($newsArray, 0, 10);

  // Render news items on the page
  foreach ($newsArray as $news) {
    ?>

    <div class="wall-item mb-3">
      <div class="wall-item-header">
        <div class="wall-item-image">
          <?php if ($news->groupid != false): ?>
            <img src="view/images/wall-group.svg" alt="icon">
          <?php elseif ($news->eventid != false): ?>
            <img src="view/images/wall-event.svg" alt="icon">
          <?php else: ?>
            <img src="view/images/wall-news.svg" alt="icon">
          <?php endif; ?>
        </div>

        <div class="wall-item-title"><b><?= htmlspecialchars($news->title) ?></b></div>
        <div class="wall-item-date small grey"><?= date('d.m.Y (H:i)', $news->date) ?></div>
      </div>

      <div class="wall-item-content"><?= htmlspecialchars($news->text) ?></div>
      <div class="clear"></div>
      <hr>
    </div>

    <?php
  }
  ?>
</div>