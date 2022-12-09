<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['staffname']);
unset($_SESSION['staffpic']);
echo "<script>window.location.href='../login';</script>";

?>