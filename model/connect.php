<?php


$connect = mysqli_connect('localhost', 'root', '', 'ogg');

if (!($connect)) {
  echo 'Problem connection to DB!';
  exit();
}