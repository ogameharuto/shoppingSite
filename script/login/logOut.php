<?php
session_start();
unset($_SESSION['store']);

header('Location: loginMenu.php');
?>