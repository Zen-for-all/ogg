<?php
// Detect hashtag or search value
$hashtag_title = $_GET['hashtag'] ?? $_GET['search'] ?? null;

// Hashtag link for other usage
$hashtag_link = $hashtag_title ? '&hashtag=' . urlencode($hashtag_title) : '';

// Get path from URL without query
$uri_path = strtok($_SERVER['REQUEST_URI'], '?');

// If path is root '/' and 'page' parameter exists, use its value as path
if ($uri_path === '/' && !empty($_GET['page'])) {
  $current_path = '/' . trim($_GET['page'], '/');
} else {
  $current_path = $uri_path; // already clean path
}
?>
<div class="row">
  <div class="col-md-6">
    <p>Найти по тегу</p>
    <form action="<?= htmlspecialchars($current_path) ?>" method="get">
      <input type="text"
             class="form-control no_space"
             name="search"
             value="<?= $hashtag_title ? htmlspecialchars($hashtag_title) : '' ?>">
      <input type="submit" value="Искать" class="btn btn-outline-success btn_show mt-3">
    </form>
  </div>
</div>
<br><br>

<?php if ($hashtag_title) { ?>
  <h3>#<?= htmlspecialchars($hashtag_title) ?>
    <a href="<?= htmlspecialchars($current_path) ?>">(x)</a>
  </h3><br>
<?php } ?>
