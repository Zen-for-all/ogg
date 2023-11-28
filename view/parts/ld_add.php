<h2>Добавить запись:</h2>
<form action="../../model/add_ld.php" method="post">
  <input type="date" name="date">Дата<br>
  <input type="time" name="time">Время<br>
  <input type="number" name="duration">Длительность<br>

  <select name="location">
    <option value="1">Значение 1</option>
    <option value="2">Значение 2</option>
    <option value="3">Значение 3</option>
  </select>
  Локация<br>

  <input type="number" name="quality" min="1" max="10">Качество<br>
  <input type="number" name="interest" min="1" max="10">Интерес<br>

  <select name="method">
    <option value="1">Значение 1</option>
    <option value="2">Значение 2</option>
    <option value="3">Значение 3</option>
  </select>
  Метод входа<br>

  <p>Описание</p>
  <textarea name="text"></textarea><br>
  <p>Заметки</p>
  <textarea name="notice"></textarea><br>
  <input type="submit">
</form>