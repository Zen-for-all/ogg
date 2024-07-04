<?php
// personal info
if ($user->ldlist != false) {
  $ldArrayObjects =  getLd($user->ldlist);
  $quantityLd = count($ldArrayObjects);
  $averageDuration = getAverageDuration($ldArrayObjects);
  $averageQuality = getAverageQuality($ldArrayObjects);
  $averageInterest = getAverageInterest($ldArrayObjects);
  $lastDate = getLastLdDate($ldArrayObjects);
  $summDuration = getDuration($ldArrayObjects);
  $hoursDuration = floor($summDuration / 3600);
  $minutesDuration = floor(($summDuration % 3600) / 60);
  $secondsDuration = $summDuration % 60;
  $intervalLastLd = getIntervalLastLd($lastDate);
  $maxDuration = getLongestLd($ldArrayObjects);
}

// global info
$ldArrayObjectsGlobal = getAllLd();
if ($ldArrayObjectsGlobal != false) {
  $quantityLdGlobal = count($ldArrayObjectsGlobal);
  if ($quantityLdGlobal > 0) {
    $averageDurationGlobal = 0;
    $averageQualityGlobal = 0;
    $averageInterestGlobal = 0;
    $summDurationGlobal = getDuration($ldArrayObjectsGlobal);
    $hoursDurationGlobal = floor($summDurationGlobal / 3600);
    $minutesDurationGlobal = floor(($summDurationGlobal % 3600) / 60);
    $secondsDurationGlobal = $summDurationGlobal % 60;
    $userQuantity = getUserQuantity();
    $averageDurationGlobal = getAverageDuration($ldArrayObjectsGlobal);
    $averageQualityGlobal = getAverageQuality($ldArrayObjectsGlobal);
    $averageInterestGlobal = getAverageInterest($ldArrayObjectsGlobal);
    $maxDurationGlobal = getLongestLd($ldArrayObjectsGlobal);
  }
}
?>

<section class="block">
  <?php if ($user->ldlist != false && $quantityLd > 0) { ?>
    <h3>Личная статистика <b></b><?=$user->login?>:</h3>
    <p>Всего ОСов: <?=$quantityLd?></p>

    <?php if ($summDuration != 0) { ?>
      <p>Общая длительность: <?php echo "$hoursDuration ч, $minutesDuration мин, $secondsDuration сек";?></p>
    <?php } ?>

    <?php if ($averageDuration != null) { ?>
      <p>Средняя длительность: <?=$averageDuration?> сек</p>
    <?php } ?>

    <?php if ($averageQuality != null) { ?>
      <p>Среднее качество: <?=$averageQuality?></p>
    <?php } ?>

    <?php if ($averageInterest != null) { ?>
      <p>Средняя интересность: <?=$averageInterest?></p>
    <?php } ?>

    <?php if ($maxDuration != 0) { ?>
      <p>Самый длинный ОС: <?=$maxDuration?> сек</p>
    <?php } ?>

    <?php if ($quantityLd != 0) { ?>
      <p>Последний был: <?=$lastDate?> (<?=$intervalLastLd?>д назад)</p>
    <?php } ?>

    <div class="clear pT20"></div>
  <?php } ?>

  <?php if ($ldArrayObjectsGlobal != false && $userQuantity > 0) { ?>
    <h3>Общая статистика:</h3>
    <p>Количество участников: <?=$userQuantity?></p>
    <p>Всего ОСов: <?=$quantityLdGlobal?></p>

    <p>Общая длительность: <?php echo "$hoursDurationGlobal ч, $minutesDurationGlobal мин, $secondsDurationGlobal сек";?></p>
    <p>Средняя длительность: <?=$averageDurationGlobal?> сек</p>
    <p>Среднее качество: <?=$averageQualityGlobal?></p>
    <p>Средняя интересность: <?=$averageInterestGlobal?></p>
    <p>Самый длинный ОС: <?=$maxDurationGlobal?> сек</p>
  <?php } ?>
</section>