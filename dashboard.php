<?php

$userrole=$_SESSION['EmpUserrole'];

$dashboard="dashboard/$userrole.php";
include $dashboard;



?>