<?php
/**
 * @var $user
 * @var $title
 */

// Check if user has ldlist
if ($user->ldlist) {
  $ldArrayObjects = getLd($user->ldlist);
  $quantityLd = count($ldArrayObjects);
  $averageDuration = getAverageDuration($ldArrayObjects);
  $averageQuality = getAverageQuality($ldArrayObjects);
  $averageInterest = getAverageInterest($ldArrayObjects);
  $lastDate = getLastLdDate($ldArrayObjects);
  $summDuration = getDuration($ldArrayObjects);

  // Calculate duration components
  $hoursDuration = intdiv($summDuration, 3600);
  $minutesDuration = intdiv($summDuration % 3600, 60);
  $secondsDuration = $summDuration % 60;

  // Other calculations
  $intervalLastLd = getIntervalLastLd($lastDate);
  $maxDuration = getLongestLd($ldArrayObjects);
  $methodPercent = methodPercent($ldArrayObjects);
}
?>

<section class="container">
  <div class="row">
    <div class="col-md-6">
      <?= $title ?>
      <p>Всего ОСов: <b><?= $quantityLd ?? 0 ?></b></p>

      <?php if (!empty($summDuration)) : ?>
        <p>Общая длительность: <b><?= $hoursDuration ?> ч, <?= $minutesDuration ?> мин, <?= $secondsDuration ?> сек</b></p>
      <?php endif; ?>

      <?php if (!empty($averageDuration)) : ?>
        <p>Средняя длительность: <b><?= $averageDuration ?></b> сек</p>
      <?php endif; ?>

      <?php if (!empty($averageQuality)) : ?>
        <p>Среднее качество: <b><?= $averageQuality ?></b></p>
      <?php endif; ?>

      <?php if (!empty($averageInterest)) : ?>
        <p>Средняя интересность: <b><?= $averageInterest ?></b></p>
      <?php endif; ?>

      <?php if (!empty($maxDuration)) : ?>
        <p>Самый длинный ОС: <b><?= $maxDuration ?></b> сек</p>
      <?php endif; ?>

      <?php if (!empty($quantityLd)) : ?>
        <p>Последний был: <b><?= $lastDate ?? 'N/A' ?></b> (<?= $intervalLastLd ?? 0 ?> д назад)</p>
      <?php endif; ?>

      <?php if (!empty($methodPercent)) : ?>
        <h5 class="mt-4">Распределение по методу:</h5>
        <ul>
          <?php foreach ($methodPercent as $title => $num) : ?>
            <?php if (!empty($num[1])) : ?>
              <li><?= $title ?>: <b><?= $num[1] ?></b>% (<?= $num[0] ?>)</li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>

    <div class="col-md-6">
      qwerty
    </div>
  </div>
</section>
