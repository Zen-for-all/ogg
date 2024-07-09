<h3 class="mb-3">Импортировать ОСы из .xlsx файла</h3>

<em>(файл -> экспорт -> изменить тип файла -> "Текстовые файлы (с разделителями табуляции) .txt")</em>

<form method="post" action="../../model/import_ld.php" enctype="multipart/form-data">
  <label for="fileInput" class="form-label">Выберите файл:</label>
  <input type="file" class="form-control" name="txt_file" accept=".txt" /><br>
  <input type="submit" class="btn btn-outline-secondary mb-3" name="upload_txt" value="Загрузить" />
</form>

<!--<h2>Экспортировать ОСы в .csv файл</h2>
<form action="">
  <button type="submit">Скачать</button>
</form>-->