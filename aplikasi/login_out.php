<?php
session_start();
unset($_SESSION['user']); unset($_SESSION['akses']);
session_destroy(); header('location:../index.php');
?>