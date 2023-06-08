<?php include 'view/parts/location_list.php'; ?>

<div class="clear pT20"></div>
<hr>
<div class="clear pT20"></div>

<h2>Добавить локацию:</h2>
<form action="../../model/add_location.php" method="post">
  <input type="text" name="title">Заголовок<br>

  <p>Описание</p>
  <textarea name="text"></textarea><br>

  <input type="submit">
</form>