<?php 
ob_start();
session_start();

?>
<?php
// if (!isset($_SESSION['empid'])) {
//   // Redirect to the login page
//   header("Location: login.php");
   
// }
if (isset($_SESSION['EmpId'])) {
  $admindashboard = 'active';
include 'header.php';
include 'sidebar.php';
include 'dashboard.php';
}else{
  header("Location: login.php");
}

  ?>
  <?php 
  ob_end_flush();
  ?>