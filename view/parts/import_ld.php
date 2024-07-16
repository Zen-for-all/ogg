<h3 class="mb-3">Импортировать ОСы из .tsv файла</h3>

<form method="post" action="../../model/import_ld.php" enctype="multipart/form-data">
  <label for="fileInput" class="form-label">Выберите файл (.tsv):</label>
  <input type="file" class="form-control" name="txt_file" accept=".tsv" /><br>
  <input type="submit" class="btn btn-outline-secondary mb-4" name="upload_txt" value="Импортировать" />
</form>

<h6>Для загрузки данных Google таблицы в файл формата .tsv:</h6>

<ol>
  <li>Открой Google таблицу с списком осознанных снов.</li>
  <li>Отредактируй структуру колонок, чтоб она соответствовала:</li>
  <ul>
    <li>Дата (в формате 07.07.24, обязательное значение)</li>
    <li>Время (в формате 7:00)</li>
    <li>Длительность (в секундах)</li>
    <li>Локация</li>
    <li>Качество (от 1 до 10)</li>
    <li>Интерес (от 1 до 10)</li>
    <li>Метод</li>
    <li>Описание опыта (текст)</li>
    <li>Заметки (текст)</li>
    <em>(Если у тебя нет данных для всех колонок, то создай их пустыми)</em>
  </ul>
  <li>Удали лишние колонки и строки.</li>
  <li>Перейди в меню "Файл" -> "Скачать" -> "Формат TSV (.tsv)".</li>  
</ol>