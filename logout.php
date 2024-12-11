<?php
session_start();
session_destroy();
header("Location: pilihlogin.php");
exit();
?>