<div class="container">
  <a class="btn btn-light mb-4" href="/?page=journal"><- К дневнику</a>

  <?php
  $ldValue = $_GET['id'];

  // get all info about ld
  $ld = new Ld($ldValue);

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

  <div class="">
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

  </div>

  <div class="edit_ld_form hide mt-5">
    <h2>Редактировать запись:</h2>

    <?php include 'view/parts/note/ld_add.php'; ?>

  </div>

  <!-- button for edit ld -->
  <div class="edit_ld_btn show btn mt-5 mb-3">
    <span class="show">Редактировать</span>
    <span class="hide">Отменить</span>
  </div>

  <!-- button for delete ld -->
  <div class="delete_ld show mb-5">
    <form action="model/note/delete_ld.php" method="post">
      <input type="hidden" name="delete" value="<?=$ldValue?>">
      <input type="submit" value="Удалить" class="btn btn-outline-danger">
    </form>
  </div>
</div>