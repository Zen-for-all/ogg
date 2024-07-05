<div class="container">
  <?php
  $idLd = $_GET['id'];

  // get all info about ld
  $ld = new Ld($idLd);

  // get all info about location
  if ($ld->location != false) {
    $location = new Location($ld->location);
    $locationId = $location->id;
    $locationTitle = $location->title;
  } else {
    $locationTitle = false;
  }

  $ldDate = $ld->date;

  if ($ld->time != 0) {
    $ldTime = $ld->time;
  } else {
    $ldTime = false;
  }

  if ($ld->duration != 0) {
    $ldDuration = $ld->duration;
  } else {
    $ldDuration = false;
  }

  if ($ld->quality != 0) {
    $ldQuality = $ld->quality;
  } else {
    $ldQuality = false;
  }

  if ($ld->interest != 0) {
    $ldInterest = $ld->interest;
  } else {
    $ldInterest = false;
  }

  if ($ld->method != 0) {
    $ldMethod = $enterMethod[$ld->method];
  } else {
    $ldMethod = false;
  }

  if ($ld->text != 0) {
    $ldText = $ld->text;
  } else {
    $ldText = false;
  }

  if ($ld->notice != 0) {
    $ldNotice = $ld->notice;
  } else {
    $ldNotice = false;
  }
  ?>

  <?=$ldDate;?>
  <br>

  <?php if ($ldTime != false) {
    echo $ldTime;
  } ?>
  <br>

  <?php
  if ($ldDuration != false) {
    echo 'Длительность: ' . $ldDuration;
    echo '<br>';
  }

  if ($locationTitle != false) {
    echo 'Локация: ' . $locationTitle;
    echo '<br>';
  }

  if ($ldQuality != false) {
    echo 'Качество: ' . $ldQuality;
    echo '<br>';
  }

  if ($ldInterest != false) {
    echo 'Интерес: ' . $ldInterest;
    echo '<br>';
  }

  if ($ldMethod != false) {
    echo 'Метод входа: ' . $ldMethod;
    echo '<br>';
  }

  if ($ldText != false) {
    echo '<br>';
    echo 'Описание:<br>';
    echo $ldText;
    echo '<br>';
  }

  if ($ldNotice != false) {
    echo '<br>';
    echo 'Заметки:<br>';
    echo $ldNotice;
    echo '<br>';
  }
  ?>

  <br>
  <a href="javascript:history.back()"><- Назад</a>
</div>