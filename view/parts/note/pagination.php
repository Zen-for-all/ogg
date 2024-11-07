<?php
// Get the current URL
$currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$urlComponents = parse_url($currentURL);

// Build the base URL without the 'p' parameter
$updatedURL = $urlComponents['scheme'] . '://' . $urlComponents['host'] . $urlComponents['path'];

// If there is a query string, parse it
if (isset($urlComponents['query'])) {
  $queryParams = [];
  parse_str($urlComponents['query'], $queryParams);

  // Remove 'p' parameter if it exists
  unset($queryParams['p']);

  // Rebuild the query string without 'p'
  $updatedQuery = http_build_query($queryParams);

  // Append the rebuilt query string to the base URL
  if (!empty($updatedQuery)) {
    $updatedURL .= '?' . $updatedQuery;
  }
} else {
  // If there is no query string, keep the base URL as is
  $updatedURL = $urlComponents['scheme'] . '://' . $urlComponents['host'] . $urlComponents['path'];
}
?>

<?php if (isset($pages) && $pages > 1) { ?>
  <nav>
    <ul class="pagination">
      <?php if ($current_page != 1) { ?>
        <!-- Link to the previous page -->
        <li class="page-item"><a class="page-link" href="<?php echo $updatedURL . (strpos($updatedURL, '?') === false ? '?' : '&') . 'p=' . ($current_page - 1); ?>">&#60;</a></li>
      <?php } ?>

      <!-- Loop to generate page numbers -->
      <?php for ($i = 1; $i <= $pages; $i++) { ?>
        <?php if ($i == $current_page || $i == 1 || $i == $pages || $i == ($current_page - 1) || $i == ($current_page + 1)) { ?>
          <?php if ($i == $current_page) { ?>
            <!-- Current page (disabled link) -->
            <li class="page-item disabled"><a class="page-link"><?php echo $i; ?></a></li>
          <?php } else { ?>
            <!-- Link to a different page -->
            <li class="page-item"><a class="page-link" href="<?php echo $updatedURL . (strpos($updatedURL, '?') === false ? '?' : '&') . 'p=' . $i; ?>"><?php echo $i; ?></a></li>
          <?php } ?>
        <?php } ?>
      <?php } ?>

      <?php if ($current_page != $pages) { ?>
        <!-- Link to the next page -->
        <li class="page-item"><a class="page-link" href="<?php echo $updatedURL . (strpos($updatedURL, '?') === false ? '?' : '&') . 'p=' . ($current_page + 1); ?>">&#62;</a></li>
      <?php } ?>
    </ul>
  </nav>
<?php } ?>