<?php
session_start();
unset($_SESSION['customer']);

header('Location: customerloginMenu.php');
?>