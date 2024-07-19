<?php
// Establish a database connection
$connect = mysqli_connect('localhost', 'root', '', 'ogg');

// Check connection
if (!$connect) {
  die('Problem connecting to DB: ' . mysqli_connect_error());
}