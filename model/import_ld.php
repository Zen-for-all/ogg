<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["upload_csv"])) {
  // Проверяем, был ли файл загружен без ошибок
  if (isset($_FILES["csv_file"]) && $_FILES["csv_file"]["error"] == UPLOAD_ERR_OK) {
    // Получаем содержимое файла
    $csv_content = file_get_contents($_FILES["csv_file"]["tmp_name"]);

    // Исходная строка CSV
    $csvString = $csv_content; // Вставьте сюда вашу строку

    // Разделитель, учитывающий кавычки
    $delimiter = ',';

    // Подготовим временный файл и запишем в него строку CSV
    $tempFile = tempnam(sys_get_temp_dir(), 'csv_temp');
    file_put_contents($tempFile, $csvString);

    // Откроем временный файл и считаем данные с учётом кавычек
    $handle = fopen($tempFile, "r");
    $array_ld = [];
    if ($handle) {
      while (($data = fgetcsv($handle, 0, $delimiter, '"')) !== false) {
          // Обработка данных, например, добавление в массив
        $array_ld[] = $data;
      }
      fclose($handle);
    }

    // Удалим временный файл
    unlink($tempFile);
  } else {
    echo "Ошибка при загрузке файла.";
  }
}

echo '<pre>';
var_dump($array_ld);
echo '</pre>';