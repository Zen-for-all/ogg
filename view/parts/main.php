<section class="block">
  <?php
  // personal info
  if ($user->ldlist != false) {
    $ldArrayObjects =  getLd($user->ldlist);
    $quantityLd = count($ldArrayObjects);
    $averageDuration = getAverageDuration($ldArrayObjects);
    $averageQuality = getAverageQuality($ldArrayObjects);
    $averageInterest = getAverageInterest($ldArrayObjects);
    $lastDate = getLastLdDate($ldArrayObjects);
    $summDuration = getQuantity($ldArrayObjects);
    $hoursDuration = floor($summDuration / 3600);
    $minutesDuration = floor(($summDuration % 3600) / 60);
    $secondsDuration = $summDuration % 60;
    $intervalLastLd = getIntervalLastLd($lastDate);
  }

  // global info
  $quantityLdGlobal = count(getAllLd());
  if ($quantityLdGlobal > 0) {
    $averageDurationGlobal = 0;
    $averageQualityGlobal = 0;
    $averageInterestGlobal = 0;
    $summDurationGlobal = 0;
    $hoursDurationGlobal = floor($summDurationGlobal / 3600);
    $minutesDurationGlobal = floor(($summDurationGlobal % 3600) / 60);
    $secondsDurationGlobal = $summDurationGlobal % 60;
    $userQuantity = getUserQuantity();
  }
  ?>

  <?php if ($quantityLd > 3) { ?>
    <h3>Личная статистика</h3>
    <p>Всего ОСов: <?=$quantityLd?></p>
    <p>Общая длительность: <?php echo "$hoursDuration ч, $minutesDuration мин, $secondsDuration сек";?></p>
    <p>Средняя длительность: <?=$averageDuration?> сек</p>
    <p>Среднее качество: <?=$averageQuality?></p>
    <p>Средняя интересность: <?=$averageInterest?></p>

    <?php if ($quantityLd > 3) { ?>
      <p>Последний был: <?=$lastDate?> (<?=$intervalLastLd?>д назад)</p>
    <?php } ?>
    <div class="clear pT20"></div>
  <?php } ?>

  <?php if (1) { ?>
    <h3>Общая статистика</h3>
    <p>Количество участников: <?=$userQuantity?></p>
    <p>Всего ОСов: <?=$quantityLdGlobal?></p>
    <p>Общая длительность: <?php echo "$hoursDuration ч, $minutesDuration мин, $secondsDuration сек";?></p>
    <p>Средняя длительность: <?=$averageDuration?> сек</p>
    <p>Среднее качество: <?=$averageQuality?></p>
    <p>Средняя интересность: <?=$averageInterest?></p>
  <?php } ?>
</section>