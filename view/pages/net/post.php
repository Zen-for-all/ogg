<?php
/**
 * @var $enterMethod
 * @var object $connect The database connection object used to interact with the database.
 */
?>

<?php
$ldValue = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($ldValue === 0) {
  header("Location: /posts");
  exit;
}

// Get all info about ld
$ld = new Ld($ldValue);
?>

<?php if ((int)$ld->publish === 1): ?>
  <?php
  // Get all info about location
  $locationTitle = false;
  if ($ld->location) {
    $location = new Location($ld->location);
    $locationTitle = $location->title;
  }

  // Get author id & name
  $userid = $ld->user;
  $user = new User($userid);
  $username = $user->login;

  $ldDate = $ld->date;
  $ldTime = ($ld->time != 0) ? $ld->time : false;
  $ldDuration = ($ld->duration != 0) ? $ld->duration : false;
  $ldQuality = ($ld->quality != 0) ? $ld->quality : false;
  $ldInterest = ($ld->interest != 0) ? $ld->interest : false;
  $ldMethod = ($ld->method != 0) ? $enterMethod[$ld->method] : false;
  $ldText = ($ld->text != 0) ? $ld->text : false;
  $ldNotice = ($ld->notice != 0) ? $ld->notice : false;
  $ldPublicText = ($ld->public_text != 0) ? $ld->public_text : false;
  $ldPublish = $ld->publish;
  $hashtags = (!empty($ld->hashtags)) ? json_decode($ld->hashtags, true) : false;

  // likes
  $likes = ($ld->likes != 0) ? $ld->likes : false;
  if (is_string($likes) && !empty($likes)) {
    $likes = json_decode($likes, true);
  }
  if (!is_array($likes)) {
    $likes = [];
  }

  // views
  $views = ($ld->views != 0) ? $ld->views : false;

  // Convert views to array
  if (is_string($views) && !empty($views)) {
    $views = json_decode($views, true);
  }
  if (!is_array($views)) {
    $views = [];
  }

  // Check if userId is already in views
  if (!in_array($_SESSION['userId'], $views, true)) {
    $views[] = $_SESSION['userId']; // Add user to views

    // Encode views back to JSON format
    $new_views = json_encode($views, JSON_UNESCAPED_UNICODE);

    // Update the database record
    $query = "UPDATE `ld` SET `views` = ? WHERE `id` = ?";
    require 'model/connect.php';
    $stmt = mysqli_prepare($connect, $query);
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "si", $new_views, $ldValue);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
  }
  ?>

  <a class="btn btn-light mb-4" href="/posts"><- Все публикации</a>

  <div class="w-100">
    <?=$ldDate;?>
    <br>
    <?php if ($ldDuration) { echo 'Длительность: ' . $ldDuration . ' сек<br>'; } ?>
    <?php if ($ldQuality) { echo 'Качество: ' . $ldQuality . '<br>'; } ?>
    <?php if ($ldInterest) { echo 'Интерес: ' . $ldInterest . '<br>'; } ?>
    <?php if ($ldMethod) { echo 'Метод входа: ' . $ldMethod . '<br>'; } ?>

    <?php if ($hashtags) {
      echo '<br>Теги:<br>';
      foreach ($hashtags as $hashtag) {
        echo '<a href="/?page=posts&hashtag=' . $hashtag . '">#' . $hashtag . '</a> | ';
      }
      echo '<br>';
    } ?>

    <?php if ($ldPublicText) { echo '<br>Публичное описание:<br>' . html_entity_decode($ldPublicText) . '<br>'; } ?>

    Автор: <a href="/?page=profile&id=<?php echo $userid; ?>"><?php echo $username; ?></a>

    <br><br>
    <div class="button-container w-100">
      <!-- Likes -->
      <div class="rl icon-count-block">
        <div class="rl icon-img">
          <form action="model/net/like.php" method="POST" class="like-form">
            <input type="hidden" name="id" value=<?php echo $ldValue; ?>>
            <input type="hidden" name="user_id" value=<?php echo $_SESSION['userId']; ?>>
            <button type="submit" class="btn-view">
              <!-- Like icon -->
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
              </svg>
            </button>
          </form>
        </div>
        <div class="rl like-count">
          <?php echo count($likes); ?>
        </div>
      </div>

      <!-- Views -->
      <div class="rl icon-count-block">
        <div class="rl icon-img">
          <svg enable-background="new 0 0 32 32" id="Editable-line" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="  M16,7C9.934,7,4.798,10.776,3,16c1.798,5.224,6.934,9,13,9s11.202-3.776,13-9C27.202,10.776,22.066,7,16,7z" fill="none" id="XMLID_10_" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/><circle cx="16" cy="16" fill="none" id="XMLID_12_" r="5" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/></svg>
        </div>
        <div class="rl view-count">
          <?php echo count($views); ?>
        </div>
      </div>
    </div>
    <div class="clear"></div>
  </div>

  <?php if ($_SESSION['userId'] === (int)$ld->user): ?>
    <div class="w-100">
      <div class="edit_ld_form hide mt-5">
        <h2>Редактировать запись:</h2>
        `<?php include 'view/parts/note/ld_add.php'; ?>`
      </div>

      <!-- Button for edit ld -->
      <div class="edit_ld_btn show btn mt-5 mb-3">
        <span class="show">Редактировать запись</span>
        <span class="hide">Отменить</span>
      </div>

      <!-- Button for delete ld -->
      <div class="delete_ld show mb-5">
        <form action="model/note/delete_ld.php" method="post">
          <input type="hidden" name="delete" value="<?=$ldValue?>">
          <input type="submit" value="Удалить запись" class="btn btn-outline-danger">
        </form>
      </div>
    </div>
  <?php endif; ?>
<?php endif; ?>
