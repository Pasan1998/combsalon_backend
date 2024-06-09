<?php

include 'sidebar.php';
session_start();
date_default_timezone_set('Asia/Colombo');

session_destroy();

header("Location:login.php");
?>