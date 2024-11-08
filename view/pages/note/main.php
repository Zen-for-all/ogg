<?php
/**
 * @var $user
 */
?>

<?php
// Personal info section
if ($user->ldlist != false) {
  $ldArrayObjects = getLd($user->ldlist);
  $quantityLd = count($ldArrayObjects);
  $summDuration = getDuration($ldArrayObjects);
  $hoursDuration = floor($summDuration / 3600);
  $minutesDuration = floor(($summDuration % 3600) / 60);
  $secondsDuration = $summDuration % 60;
  $lastDate = getLastLdDate($ldArrayObjects);
  $intervalLastLd = getIntervalLastLd($lastDate);
  $averageDuration = getAverageDuration($ldArrayObjects);
  $averageQuality = getAverageQuality($ldArrayObjects);
  $averageInterest = getAverageInterest($ldArrayObjects);
  $maxDuration = getLongestLd($ldArrayObjects);
  $methodPercent = methodPercent($ldArrayObjects);
}

// Global info section
$ldArrayObjectsGlobal = getAllLd();
if ($ldArrayObjectsGlobal != false) {
  $quantityLdGlobal = count($ldArrayObjectsGlobal);
  $summDurationGlobal = getDuration($ldArrayObjectsGlobal);
  $hoursDurationGlobal = floor($summDurationGlobal / 3600);
  $minutesDurationGlobal = floor(($summDurationGlobal % 3600) / 60);
  $secondsDurationGlobal = $summDurationGlobal % 60;
  $userQuantity = getUserQuantity();
  $averageDurationGlobal = getAverageDuration($ldArrayObjectsGlobal);
  $averageQualityGlobal = getAverageQuality($ldArrayObjectsGlobal);
  $averageInterestGlobal = getAverageInterest($ldArrayObjectsGlobal);
  $maxDurationGlobal = getLongestLd($ldArrayObjectsGlobal);
  $lastDateGlobal = getLastLdDate($ldArrayObjectsGlobal);
  $intervalLastLdGlobal = getIntervalLastLd($lastDateGlobal);
  $methodPercentGlobal = methodPercent($ldArrayObjectsGlobal);
}
?>

<div class="row">
  <?php if ($user->ldlist != false && $quantityLd > 0) { ?>
    <div class="col-md-6 mb-5 mb-md-0">
      <h3 class="mb-3">Личная статистика <b><?=$user->login?>:</b></h3>
      <p>Всего ОСов: <b><?=$quantityLd?></b></p>

      <?php if ($summDuration != 0) { ?>
        <p>Общая длительность: <b><?= "$hoursDuration ч, $minutesDuration мин, $secondsDuration сек"; ?></b></p>
      <?php } ?>

      <?php if ($averageDuration !== null) { ?>
        <p>Средняя длительность: <b><?=$averageDuration?></b> сек</p>
      <?php } ?>

      <?php if ($averageQuality !== null) { ?>
        <p>Среднее качество: <b><?=$averageQuality?></b></p>
      <?php } ?>

      <?php if ($averageInterest !== null) { ?>
        <p>Средняя интересность: <b><?=$averageInterest?></b></p>
      <?php } ?>

      <?php if ($maxDuration != 0) { ?>
        <p>Самый длинный ОС: <b><?=$maxDuration?></b> сек</p>
      <?php } ?>

      <?php if ($quantityLd != 0) { ?>
        <p>Последний был: <b><?=$lastDate?></b> (<?=$intervalLastLd?>д назад)</p>
      <?php } ?>

      <?php if (!empty($methodPercent)) { ?>
        <h5 class="mt-4">Распределение по методу:</h5>
        <ul>
          <?php foreach ($methodPercent as $title => $num) {
            if ($num != 0) { ?>
              <li><?=$title?>: <b><?=$num[1]?></b>% (<?=$num[0]?>)</li>
            <?php }
          } ?>
        </ul>
      <?php } ?>

      <!-- Print graphics -->
      <?php
      printYears($ldArrayObjects);
      printYears($ldArrayObjects, 'duration');
      printYears($ldArrayObjects, 'quality');
      printYears($ldArrayObjects, 'interest');
      ?>
    </div>
  <?php } ?>

  <div class="col-md-6">
    <?php if ($ldArrayObjectsGlobal != false && $userQuantity > 0) { ?>
      <h3 class="mb-3">Общая статистика проекта:</h3>
      <p>Всего ОСов: <b><?=$quantityLdGlobal?></b> (<?=$userQuantity?> участников)</p>
      <p>Общая длительность: <b><?= "$hoursDurationGlobal ч, $minutesDurationGlobal мин, $secondsDurationGlobal сек"; ?></b></p>
      <p>Средняя длительность: <b><?=$averageDurationGlobal?></b> сек</p>
      <p>Среднее качество: <b><?=$averageQualityGlobal?></b></p>
      <p>Средняя интересность: <b><?=$averageInterestGlobal?></b></p>
      <p>Самый длинный ОС: <b><?=$maxDurationGlobal?></b> сек</p>
      <p>Последний был: <b><?=$lastDateGlobal?></b> (<?=$intervalLastLdGlobal?>д назад)</p>

      <?php if (!empty($methodPercentGlobal)) { ?>
        <h5 class="mt-4">Распределение по методу:</h5>
        <ul>
          <?php foreach ($methodPercentGlobal as $title => $num) {
            if ($num != 0) { ?>
              <li><?=$title?>: <b><?=$num[1]?></b>% (<?=$num[0]?>)</li>
            <?php }
          } ?>
        </ul>
      <?php } ?>
    <?php } ?>
  </div>
</div>
