<a class="btn btn-light mb-4" href="/?page=journal"><- К дневнику</a>

<?php
$ldValue = $_GET['id'];

// get all info about ld
$ld = new Ld($_GET['id']);

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

if ($ld->public_text != 0) {
  $ldPublicText = $ld->public_text;
} else {
  $ldPublicText = false;
}

$ldPublish = $ld->publish;

if (!empty($ld->hashtags)) {
  $hashtags = json_decode($ld->hashtags, true);
} else {
  $hashtags = false;
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

  if ($hashtags!= false) {
    echo '<br>';
    echo 'Хэштеги:<br>';
    foreach ($hashtags as $hashtag) {
      echo '<a href="/?page=journal&hashtag=' . $hashtag . '">#' . $hashtag . '</a> | ';
    }
    echo '<br>';
  }

  if ($ldPublicText != false) {
    echo '<br>';
    echo 'Публичное описание:<br>';
    echo html_entity_decode($ldPublicText);
    echo '<br>';
  }

  echo '<br>';
  if ($ldPublish == 1) {
    echo 'Опубликовано';
  } else {
    echo 'Черновик';
  }
  echo '<br>';
  ?>

</div>

<div class="edit_ld_form hide mt-5">
  <h2>Редактировать запись:</h2>

  <?php include 'view/parts/note/ld_add.php'; ?>

</div>

<!-- button for edit ld -->
<div class="edit_ld_btn show btn mt-5 mb-3">
  <span class="show">Редактировать запись</span>
  <span class="hide">Отменить</span>
</div>

<!-- button for delete ld -->
<div class="delete_ld show mb-5">
  <form action="model/note/delete_ld.php" method="post">
    <input type="hidden" name="delete" value="<?=$ldValue?>">
    <input type="submit" value="Удалить запись" class="btn btn-outline-danger">
  </form>
</div>