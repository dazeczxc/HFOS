<?php
session_start();
unset($_SESSION['CID']);
echo "<script>window.location.href='index';</script>";

?>