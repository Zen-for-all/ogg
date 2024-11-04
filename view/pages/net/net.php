<?php
/**
 * @var $user
 * @var $title
 */

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
  $methodPercent = methodPercent($ldArrayObjects);
}
?>

<section class="container">
  <div class="row">
    <div class="col-md-6">
      <?=$title?>
      <p>Всего ОСов: <b><?=$quantityLd?></b></p>
      <?php if ($summDuration != 0) { ?>
        <p>Общая длительность: <b><?php echo "$hoursDuration ч, $minutesDuration мин, $secondsDuration сек";?></b></p>
      <?php } ?>

      <?php if ($averageDuration != null) { ?>
        <p>Средняя длительность: <b><?=$averageDuration?></b> сек</p>
      <?php } ?>

      <?php if ($averageQuality != null) { ?>
        <p>Среднее качество: <b><?=$averageQuality?></b></p>
      <?php } ?>

      <?php if ($averageInterest != null) { ?>
        <p>Средняя интересность: <b><?=$averageInterest?></b></p>
      <?php } ?>

      <?php if ($maxDuration != 0) { ?>
        <p>Самый длинный ОС: <b><?=$maxDuration?></b> сек</p>
      <?php } ?>

      <?php if ($quantityLd != 0) { ?>
        <p>Последний был: <b><?=$lastDate?></b> (<?=$intervalLastLd?>д назад)</p>
      <?php } ?>

      <?php
      if (!empty($methodPercent)) {
        echo '<h5 class="mt-4">Распределение по методу:</h5>';
        echo '<ul>';
        foreach ($methodPercent as $title => $num) {
          if ($num != 0) {
            ?>
            <li><?=$title?>: <b><?=$num[1]?></b>% (<?=$num[0]?>)</li>
            <?php
          }
        }
        echo '</ul>';
      } ?>
    </div>

    <div class="col-md-6">
      qwerty
    </div>
  </div>
</section>