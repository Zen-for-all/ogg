<h2>Импортировать ОСы из .csv файла</h2>
<em>Получить файл в формате .csv можно сохранив Google таблицу с дополнительными настройками (Файл -> Скачать -> Формат csv)</em>
<div class="clear"></div>

<form method="post" action="../../model/import_ld.php" enctype="multipart/form-data">
  <label for="fileInput">Выберите файл:</label>
  <input type="file" name="txt_file" accept=".txt" /><br>
  <div class="clear"></div>
  <input type="submit" name="upload_txt" value="Загрузить" />
</form>
<div class="clear pT20"></div>

<h2>Экспортировать ОСы в .csv файл</h2>
<form action="">
  <button type="submit">Скачать</button>
</form>