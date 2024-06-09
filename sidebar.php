<?php

$userrole=$_SESSION['EmpUserrole'];

$dashboard="sidebar/$userrole.php";
include $dashboard;



?>