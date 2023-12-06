<section class="block">
  <?php
  $ldArrayObjects =  getLd($user->ldlist);

  $quantityLd = count($ldArrayObjects);
  $averageDuration = getAverageDuration($ldArrayObjects);
  $averageQuality = getAverageQuality($ldArrayObjects);
  $averageInterest = getAverageInterest($ldArrayObjects);

  $summDuration = getQuantity($ldArrayObjects);
  $hoursDuration = floor($summDuration / 3600);
  $minutesDuration = floor(($summDuration % 3600) / 60);
  $secondsDuration = $summDuration % 60;


  ?>

  <p>Всего ОСов: <?=$quantityLd?></p>
  <p>Общая длительность: <?php echo "$hoursDuration ч, $minutesDuration мин, $secondsDuration сек";?></p>
  <p>Средняя длительность: <?=$averageDuration?> сек</p>
  <p>Среднее качество: <?=$averageQuality?></p>
  <p>Средняя интересность: <?=$averageInterest?></p>
  <p>Последний был:</p>
</section>