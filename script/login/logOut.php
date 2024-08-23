<?php
session_start();
unset($_SESSION['store']);

unset($_SESSION['customer']);

header('Location: loginMenu.php');
?>