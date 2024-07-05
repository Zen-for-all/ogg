<?php
$currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$urlComponents = parse_url($currentURL);

if (isset($urlComponents['query'])) {
  $queryParams = [];
  parse_str($urlComponents['query'], $queryParams);

  if (isset($queryParams['p'])) {
    unset($queryParams['p']);
  }

  $updatedQuery = http_build_query($queryParams);
  $updatedURL = $urlComponents['scheme'] . '://' . $urlComponents['host'] . $urlComponents['path'];
  if (!empty($updatedQuery)) {
    $updatedURL .= '?' . $updatedQuery;
  }
}
?>

<?php if (isset($pages) && $pages > 1) { ?>
  <nav>
    <ul class="pagination">
      <?php if ($current_page != 1) { ?>
        <li class="page-item"><a class="page-link" href="<?php echo $updatedURL ?>&p=<?php echo $current_page - 1 ?>"><</a></li>
      <?php } ?>

      <?php for ($i = 1; $i <= $pages; $i++) { ?>
        <?php if ($i == $current_page || $i == 1 || $i == $pages || $i == ($current_page - 1) || $i == ($current_page + 1)) { ?>
          <?php if ($i == $current_page) { ?>
            <li class="page-item disabled"><a class="page-link" href="<?php echo $updatedURL ?>&p=<?php echo $i ?>"><?php echo $i ?></a></li>
          <?php } else { ?>
            <li class="page-item"><a class="page-link" href="<?php echo $updatedURL ?>&p=<?php echo $i ?>"><?php echo $i ?></a></li>
          <?php } ?>
        <?php } ?>
      <?php } ?>

      <?php if ($current_page != $pages) { ?>
        <li class="page-item"><a class="page-link" href="<?php echo $updatedURL ?>&p=<?php echo $current_page + 1 ?>">></a></li>
      <?php } ?>
    </ul>
  </nav>
<?php } ?>