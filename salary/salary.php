<?php
session_start();
include '../config.php';
include '../function.php';
// if (!isset($_SESSION['empid'])) {
//   // Redirect to the login page
//   header("Location: ../login.php");

// }

if (isset($_SESSION['EmpUserrole']) && ($_SESSION['EmpUserrole'] == "management" || $_SESSION['EmpUserrole'] == "stylist")) {
  // The user has the "management" role
  // echo "User has the management role.";
} else {
  // Redirect to the login page or show an unauthorized message
  header("Location:https://combsalon.lk/staff/production/page_403.html");

  
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="<?= SYSTEM_PATH ?>assets/users/logometa.png">

  <title>CombSalon </title>

  <!-- Bootstrap -->

  <link href="<?= SYSTEM_PATH ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?= SYSTEM_PATH ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="<?= SYSTEM_PATH ?>/vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- bootstrap-progressbar -->
  <link href="<?= SYSTEM_PATH ?>/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css"
    rel="stylesheet">
  <!-- bootstrap-daterangepicker -->
  <link href="<?= SYSTEM_PATH ?>/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="<?= SYSTEM_PATH ?>/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="<?= SYSTEM_PATH ?>index.php" class="site_title"><img src="<?= SYSTEM_PATH ?>assets/users/logo.jpg" class="img-fluid " style="width:50px;  border-radius: 40%;"></img> <span>Comb Salon
               </span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic img-fluid">
              <img src="<?= SYSTEM_PATH ?>assets/users/<?= $_SESSION['EmpImage'] ?>" alt="..." class="img-circle img-fluid profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2><?php echo ucfirst( $_SESSION['EmpFName'] )?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                <li><a href="<?= SYSTEM_PATH ?>index.php"><i class="fa fa-home"></i> Home </a>

                </li>

                <li><a href="<?= SYSTEM_PATH ?>services/services.php"><i class="fa fa-scissors"></i> Services </a>

</li>
<li><a href="<?= SYSTEM_PATH ?>employers/allemploers.php"><i class="fa fa-user"></i> Stylists </a>

</li>
<li><a href="<?= SYSTEM_PATH ?>reports/salesreport.php"><i class="fa fa-line-chart"></i> Reports </a>

</li>
<li><a href="<?= SYSTEM_PATH ?>users/allUsers.php"><i class="fa fa-users"></i> Users Management </a>

</li>
<li><a href="<?= SYSTEM_PATH ?>discounts/creatediscounts.php"><i class="fa fa-credit-card"></i> Discounts Management </a>

</li>
<li><a href="<?= SYSTEM_PATH ?>expenses/addexpenses.php"><i class="fa fa-money"></i>Expenses Management </a></li>


               
              </ul>
            </div>
           
          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?= SYSTEM_PATH ?>logout.php">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>
          <nav class="nav navbar-nav">
            <ul class=" navbar-right">
              <li class="nav-item dropdown open" style="padding-left: 15px;">
                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                  data-toggle="dropdown" aria-expanded="false">
                  <img class="img-fluid" src="<?= SYSTEM_PATH ?>assets/users/<?= $_SESSION['EmpImage'] ?>" alt=""><?= $_SESSION['EmpTitle']. " ". $_SESSION['EmpFName'] ?>
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                  
                  
                  <a class="dropdown-item" href="<?= SYSTEM_PATH ?>logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                </div>
              </li>

              
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
      <div class="row">
    
        <div class="col-md-12 col-sm-12  ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Salary Table <small>  </small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                  <div class="row g-3">

                    <div class="col-sm">
                      <?php
                      //                $db = dbConn();
//                $sql = "SELECT DISTINCT Model FROM vehicle";
//                $result = $db->query($sql);
                      ?>
                      <?php 
                      $sqlemployer = "SELECT * FROM tbl_emp where EmpStatus = '1' and EmpUserrole = 'stylist' ";
                      $db = dbConn();
                      $resultemployer = $db->query($sqlemployer);
                      ?>
                      <select name="payementmethod" class="form-control" required='true'>
                        <option value="">--Select Stylist--</option>
                        <?php
                        if ($resultemployer->num_rows > 0) {

                            while ($rowEmployer = $resultemployer->fetch_assoc()) {
                                ?>
                                <option value="<?= $rowEmployer['EmpId'] ?>" <?php
                        if (@$payementmethod == $rowEmployer['EmpId']) {
                            echo "selected";
                        }
                                ?> ><?php echo  ucwords($colorzz = $rowEmployer['EmpFName']); ?>

                                </option>
                                <?php
                            }
                        }
                        ?>

                      </select>
                    </div>
                    <div class="col-sm">
                   
                    <input type="date" class="form-control" name="from" placeholder="Enter From Date" max="<?php echo date('Y-m-d'); ?>" required="true">
                    </div>
                    <div class="col-sm">
                    <input type="date" class="form-control" name="to" placeholder="Enter to Date"
                      max="<?php echo date('Y-m-d'); ?>" required="true">
                  

                    </div>
                    <div class="col-sm">
                      <input type="hidden" name="CustomerId " value=">">
                      <button type="submit" class="btn btn-warning">Search</button>
                    </div>
                  </div>
                </form>
              </ul>
              <div class="clearfix"></div>
            </div>

            <div class="x_content">
              <?php
              $where = null;
              extract($_POST);
              

              if ($_SERVER['REQUEST_METHOD'] == "POST") {

                

                

                if (!empty($payementmethod)) {
                  $where .= " EmplyoeeID ='$payementmethod' AND";
                }
                if (!empty($from) && empty($to)) {
                  $where .= " SaleServiceAddedDate  = '$from' AND";
                }
                if (empty($from) && !empty($to)) {
                  $where .= " SaleServiceAddedDate  = '$to' AND";
                }
                if (!empty($from) && !empty($to)) {
                  $where .= " SaleServiceAddedDate  BETWEEN '$from' AND '$to' AND";
                }
                // if ((empty($from)) && (empty($to))) {
                //   $where .= " DATE(Addeddate) = CURDATE() AND";
                // }
              


              

              if (!empty($where)) {
                $where = substr($where, 0, -3);
                $where = "  $where";
              }

            

              //        extract($_POST);
//        if ($_SERVER['REQUEST_METHOD'] == "POST" ) {
              extract($_POST);
              //    $CustomerId = $_GET['CustomerId'];
             
             $sql = "SELECT * FROM tbl_sales_services INNER JOIN tbl_emp on tbl_sales_services.EmplyoeeID  = tbl_emp.EmpId where $where";
              $db = dbConn();
              $results = $db->query($sql);
              $i = 1;
              $totalamount = 0;

                     }
              ?>


              <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                  <thead>
                    <tr class="headings">

                      <th class="column-title">Date </th>
                      <th class="column-title">Customer </th>
                      <th class="column-title">Invoice Number </th>
                      <th class="column-title">Sale Amount </th>
                      <th class="column-title">Salary Amount </th>
                    


                    </tr>
                  </thead>
                  <?php
                  // if ($where == null){
                  //    $sql = "SELECT * FROM tbl_cashout INNER JOIN tbl_emp on tbl_cashout.Cashoutuserid = tbl_emp.EmpId WHERE DATE(Addeddate) = CURDATE()";
                  //   $db = dbConn();
                  //   $results = $db->query($sql);
                  // }
               
                  ?>

                  <tbody>
                    <?php
                    if (@$results->num_rows > 0) {
                      $i = 1;
                      $totalamount = 0;
                      while ($row = $results->fetch_assoc()) {
                        ?>
                        <tr class="even pointer">

                          <td class=" ">
                            <?= $row['SaleServiceAddedDate'] ?>
                          </td>
                          <td class=" ">
                            <?= $row['CustomerName'] ?>
                          </td>
                          <td class=" ">
                            <?= $row['TblSalesInnvoceNumber'] ?>
                          </td>
                          <td class=" ">
                            <?= $row['SaleServiceSale'] ?>
                          </td>
                          <td class=" ">
                            <?= $row['PerSalrayCost'] ?>
                          </td>
                          <?php $totalamountsalary += $row['PerSalrayCost'];
                          $totalsaleamount += $row['SaleServiceSale'];
                          ?>
                          </td>
                        </tr>
                      <?php }
                    }else{?>
                      <tr><td colspan="4">No records For Today<td><tr><?php
                    } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="3"><strong> Total Amount </strong>
                      </td>
                      <td><strong>
                        <?= number_format(@$totalsaleamount, 2) ?> </strong>
                      </td>
                      <td><strong>
                        <?= number_format(@$totalamountsalary, 2) ?> </strong>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>


            </div>
          </div>
        </div>
       
      </div>

      <?php 
      if ( $where != null){?>

      
      
      <div class="row">
    <div class="col-md-12 col-sm-12  ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Cash Out Table</h2>
          <ul class="nav navbar-right panel_toolbox">
            <div class="btn-toolbar mb-2 mb-md-0">
              
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">



          <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
              <thead>
                <tr class="headings">

                  <th class="column-title">Date </th>
                  <th class="column-title">Reason</th>
                  <th class="column-title">Amount </th>
                  

                </tr>
              </thead>

              <tbody>
                <?php
                $sqlservices = "SELECT * FROM tbl_cashout where Cashoutuserid = '$payementmethod' and Addeddate  BETWEEN '$from' AND '$to' ";
                $db = dbConn();
                $resultservices = $db->query($sqlservices);

                ?>

                <?php
                if ($resultservices->num_rows > 0) {
                  $i = 1;
                  $totalcashoutamount = 0;
                  while ($rowservices = $resultservices->fetch_assoc()) {
                    ?>
                    <tr class="even pointer">

                    <td class="">
                        <?= $rowservices['Addeddate'] ?>
                      </td>
                      
                      <td class=" ">
                        <?= ucwords($rowservices['Reasonforcashout'] )?>
                      </td>
                      <td class=" ">
                        <?= ucwords( $rowservices['Amountcashout'] )?>
                      </td>
                      <?php $totalcashoutamount += $rowservices['Amountcashout'] ?>

                    </tr>
                    <?php
                    $i++;
                  }
                }else{
                  ?>
                      <tr><td colspan="3">No records <td><tr><?php
                    } ?>
                
                

              </tbody>
              <tfoot>
                    <tr>
                      <td colspan="2"><strong> Total Amount </strong>
                      </td>
                      <td><strong>
                        <?= number_format(@$totalcashoutamount, 2) ?> </strong>
                      </td>
                    </tr>
                  </tfoot>
            </table>
          </div>


        </div>
      </div>
    </div>
  </div><?php
      }else{

      }

        ?>         
    </div>
    <!-- /page content -->
    <?php

    include '../footer.php'

      ?>