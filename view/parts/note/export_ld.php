<h3 class="mb-3">Перенос дневника в Google таблицу</h3>

<!-- Form for exporting TSV file -->
<form method="post" action="model/note/export_ld.php" enctype="multipart/form-data">
  <!-- File input label for export -->
  <label for="fileInput" class="form-label">Получите файл (.tsv):</label><br>
  <!-- Submit button for exporting to TSV -->
  <input type="submit" class="btn btn-outline-secondary mb-4" name="upload_txt" value="Экспорт в .tsv файл" />
</form>

<!-- Instructions for importing data into Google Sheets -->
<h6>Для загрузки данных из файла формата .tsv в Google таблицу:</h6>

<!-- Ordered list of steps for importing -->
<ol>
  <li>Открой Google таблицу.</li>
  <li>Перейди в меню "Файл" и выбери "Импорт".</li>
  <li>В появившемся окне нажми "Загрузить" и выбери файл формата TSV на своем компьютере.</li>
  <li>После загрузки файла выбери "Тип разделителя: Табуляция".</li>
  <li>Нажми "Импортировать данные".</li>
</ol>
