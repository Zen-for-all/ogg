<?php
session_start();
require 'connect.php';

mysqli_set_charset($connect, "utf8mb4");

$user = $_SESSION['userid'];

header('Content-Type: text/tab-separated-values');
header('Content-Disposition: attachment; filename="export.tsv"');

$output = fopen('php://output', 'w');

$columns = ["Date", "Time", "Duration", "Quality", "Interest", "Method", "Text", "Notice"];
fputcsv($output, $columns, "\t");

$query = mysqli_query($connect, "SELECT `date`, `time`, `duration`, `quality`, `interest`, `method`, `text`, `notice` FROM `ld` WHERE `user` = '$user'");

while ($row = mysqli_fetch_assoc($query)) {
  $row['date'] = DateTime::createFromFormat('d.m.y', $row['date'])->format('d.m.y');
  fputcsv($output, $row, "\t");
}

fclose($output);
exit();