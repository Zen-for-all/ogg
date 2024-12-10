<?php
/**
 * @var $enterMethod
 */
?>

<?php
$ldValue = $_GET['id'];

// Get all info about ld
$ld = new Ld($ldValue);
?>

<?php if ($_SESSION['userId'] === (int)$ld->user): ?>
  <a class="btn btn-light mb-4" href="/journal"><- К дневнику</a>

  <?php
  // Get all info about location
  $locationTitle = false;
  if ($ld->location) {
    $location = new Location($ld->location);
    $locationTitle = $location->title;
  }

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
  ?>

  <div class="">
    <?=$ldDate;?>
    <br>
    <?php if ($ldTime) { echo $ldTime . '<br>'; } ?>
    <?php if ($ldDuration) { echo 'Длительность: ' . $ldDuration . '<br>'; } ?>
    <?php if ($locationTitle) { echo 'Локация: ' . $locationTitle . '<br>'; } ?>
    <?php if ($ldQuality) { echo 'Качество: ' . $ldQuality . '<br>'; } ?>
    <?php if ($ldInterest) { echo 'Интерес: ' . $ldInterest . '<br>'; } ?>
    <?php if ($ldMethod) { echo 'Метод входа: ' . $ldMethod . '<br>'; } ?>
    <?php if ($ldText) { echo '<br>Описание:<br>' . $ldText . '<br>'; } ?>
    <?php if ($ldNotice) { echo '<br>Заметки:<br>' . $ldNotice . '<br>'; } ?>

    <?php if ($hashtags) {
      echo '<br>Теги:<br>';
      foreach ($hashtags as $hashtag) {
        echo '<a href="/?page=journal&hashtag=' . $hashtag . '">#' . $hashtag . '</a> | ';
      }
      echo '<br>';
    } ?>

    <?php if ($ldPublicText) { echo '<br>Публичное описание:<br>' . html_entity_decode($ldPublicText) . '<br>'; } ?>

    <br>
    <?= ($ldPublish == 1) ? 'Опубликовано' : 'Черновик'; ?>
    <br>
  </div>

  <div class="edit_ld_form hide mt-5">
    <h2>Редактировать запись:</h2>
    <?php include 'view/parts/note/ld_add.php'; ?>
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
<?php elseif ((int)$ld->publish === 1): ?>
  <?php
  $ldDate = $ld->date;
  $ldTime = ($ld->time != 0) ? $ld->time : false;
  $ldDuration = ($ld->duration != 0) ? $ld->duration : false;
  $ldQuality = ($ld->quality != 0) ? $ld->quality : false;
  $ldInterest = ($ld->interest != 0) ? $ld->interest : false;
  $ldMethod = ($ld->method != 0) ? $enterMethod[$ld->method] : false;
  $ldPublicText = ($ld->public_text != 0) ? $ld->public_text : false;
  $hashtags = (!empty($ld->hashtags)) ? json_decode($ld->hashtags, true) : false;
  ?>

  <div class="">
    <?=$ldDate;?>
    <br>
    <?php if ($ldDuration) { echo 'Длительность: ' . $ldDuration . '<br>'; } ?>
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

<?php else: ?>
  <h2>Запись приватная.</h2>
<?php endif; ?>


