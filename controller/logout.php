<?php
session_start();
session_unset();
session_destroy();
setcookie("userId", "", time() - 3600, "/");
header("location:/");
?>