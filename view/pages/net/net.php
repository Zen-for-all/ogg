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
      <p>Всего ОСов: <b><?php echo isset($quantityLd) && $quantityLd !== false ? $quantityLd : 0; ?></b></p>

      <?php if (isset($summDuration) && $summDuration != 0) { ?>
        <p>Общая длительность: <b><?php echo isset($hoursDuration) ? $hoursDuration : 0; ?> ч, <?php echo isset($minutesDuration) ? $minutesDuration : 0; ?> мин, <?php echo isset($secondsDuration) ? $secondsDuration : 0; ?> сек</b></p>
      <?php } ?>

      <?php if (isset($averageDuration) && $averageDuration != null) { ?>
        <p>Средняя длительность: <b><?php echo isset($averageDuration) ? $averageDuration : 0; ?></b> сек</p>
      <?php } ?>

      <?php if (isset($averageQuality) && $averageQuality != null) { ?>
        <p>Среднее качество: <b><?php echo isset($averageQuality) ? $averageQuality : 0; ?></b></p>
      <?php } ?>

      <?php if (isset($averageInterest) && $averageInterest != null) { ?>
        <p>Средняя интересность: <b><?php echo isset($averageInterest) ? $averageInterest : 0; ?></b></p>
      <?php } ?>

      <?php if (isset($maxDuration) && $maxDuration != 0) { ?>
        <p>Самый длинный ОС: <b><?php echo isset($maxDuration) ? $maxDuration : 0; ?></b> сек</p>
      <?php } ?>

      <?php if (isset($quantityLd) && $quantityLd != 0) { ?>
        <p>Последний был: <b><?php echo isset($lastDate) ? $lastDate : 'N/A'; ?></b> (<?php echo isset($intervalLastLd) ? $intervalLastLd : 0; ?> д назад)</p>
      <?php } ?>

      <?php
      if (!empty($methodPercent)) {
        echo '<h5 class="mt-4">Распределение по методу:</h5>';
        echo '<ul>';
        foreach ($methodPercent as $title => $num) {
          if (isset($num[0]) && isset($num[1]) && $num[1] != 0) {
            ?>
            <li><?php echo $title; ?>: <b><?php echo $num[1]; ?></b>% (<?php echo $num[0]; ?>)</li>
            <?php
          }
        }
        echo '</ul>';
      }
      ?>
    </div>

    <div class="col-md-6">
      qwerty
    </div>
  </div>
</section>