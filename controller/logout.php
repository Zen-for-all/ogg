<?php
session_start();
session_unset();
session_destroy();
setcookie("userid", "", time() - 3600, "/");
header("location:/");
?>