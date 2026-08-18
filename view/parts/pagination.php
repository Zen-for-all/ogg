<?php
/**
 * @var int $current_page The current page number being displayed in the pagination.
 */

// Get the current URL
$currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$urlComponents = parse_url($currentURL);

// Build the base URL without the 'p' parameter
$updatedURL = $urlComponents['scheme'] . '://' . $urlComponents['host'] . $urlComponents['path'];

// Check if there is a query string
if (isset($urlComponents['query'])) {
  // Parse the query string into an associative array
  $queryParams = [];
  parse_str($urlComponents['query'], $queryParams);

  // Remove the 'p' parameter if it exists
  unset($queryParams['p']);

  // Rebuild the query string and append it to the base URL
  $updatedQuery = http_build_query($queryParams);
  $updatedURL .= !empty($updatedQuery) ? '?' . $updatedQuery : '';
}
 if (isset($pages) && $pages > 1) { ?>
  <nav>
    <ul class="pagination">
      <?php if ($current_page != 1) { ?>
        <!-- Link to the previous page -->
        <li class="page-item"><a class="page-link" href="<?php echo $updatedURL . (strpos($updatedURL, '?') === false ? '?' : '&') . 'p=' . ($current_page - 1); ?>">&#60;</a></li>
      <?php } ?>

      <!-- Loop to generate page numbers -->
      <?php for ($i = 1; $i <= $pages; $i++) { ?>
        <?php if (in_array($i, [$current_page, 1, $pages, $current_page - 1, $current_page + 1])) { ?>
          <li class="page-item<?php echo $i == $current_page ? ' disabled' : ''; ?>">
            <a class="page-link" href="<?php echo $updatedURL . (strpos($updatedURL, '?') === false ? '?' : '&') . 'p=' . $i; ?>">
              <?php echo $i; ?>
            </a>
          </li>
        <?php } ?>
      <?php } ?>

      <?php if ($current_page != $pages) { ?>
        <!-- Link to the next page -->
        <li class="page-item"><a class="page-link" href="<?php echo $updatedURL . (strpos($updatedURL, '?') === false ? '?' : '&') . 'p=' . ($current_page + 1); ?>">&#62;</a></li>
      <?php } ?>
    </ul>
  </nav>
<?php } ?>
