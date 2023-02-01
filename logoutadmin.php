<?php
unset($_COOKIE['PHPSESSID']);
setcookie("PHPSESSID", "", time() - 300,"/");
header("Location: dashboard.php");
?>