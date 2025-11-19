<?php
// Check if either 'hashtag' or 'search' is set and assign their values
if (!empty($_GET['hashtag'])) {
  $hashtag_title = $_GET['hashtag'];
} elseif (!empty($_GET['search'])) {
  $hashtag_title = $_GET['search'];
}

// Generate hashtag link if hashtag title is set
$hashtag_link = isset($hashtag_title) ? '&hashtag=' . urlencode($hashtag_title) : '';

// get current path without query
$current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>


<div class="row">
  <div class="col-md-6">
    <p>Найти по тегу</p>
    <form action="<?= htmlspecialchars($current_path) ?>" method="get">
      <input type="text" class="form-control no_space" name="search" value="<?= isset($hashtag_title) ? htmlspecialchars($hashtag_title) : '' ?>">
      <input type="submit" value="Искать" class="btn btn-outline-success btn_show mt-3">
    </form>
  </div>
</div>
<br><br>

<?php if (!empty($hashtag_title)) { ?>
  <h3>#<?= htmlspecialchars($hashtag_title) ?> <a href="<?= htmlspecialchars($current_path) ?>">(x)</a></h3><br>
<?php } ?>