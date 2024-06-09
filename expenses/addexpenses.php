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
  header("Location:http://localhost/salon/production/page_403.html");

  
}

// if (isset($_SESSION['EmpId'])) {

// } else {
//     header("Location: " . SYSTEM_PATH . "login.php");
    
// }

//check form submit method
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'creatediscount') {


  //seperate variables and values from the form
  extract($_POST);

  //data clean
  $servicename = cleanInput($servicename);
  $cost = cleanInput($cost);


  //create array variable store validation messages
  $messages = array();

  //validate required fields

  if (empty($cost)) {
    $messages['error_cost'] = "Amount should not be empty!";
  }

  if (empty($servicename)) {
    $messages['error_servicename'] = "Description should not be empty!";
  }


  if (empty($messages)) {

    $db = dbConn();

    $AddUser = $_SESSION['EmpId'];

    $AddDate = date('y-m-d');
    $user_type = $_SESSION['EmpUserrole'];
    $sql = "INSERT INTO tbl_cashout(Cashoutuserid, Amountcashout, Addeddate,Reasonforcashout,cashoutusertype) VALUES ('$AddUser','$cost',' $AddDate','$servicename','$user_type')";
    $result = $db->query($sql);
    ?>
    <script>
      Swal.fire({
        title: 'Success!',
        text: 'Successfully Created User Account.',
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'index.php'; // Redirect to success page
      });
    </script>
    <?php
  }
}
?>
<?php
;
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

        <div class="col-md-12 ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Add New Cashout <small></small></h2>

              <ul class="nav navbar-right panel_toolbox">
                <!-- <div class="btn-toolbar mb-2 mb-md-0">
                  <div class="btn-group ">
                    <a href="<?= SYSTEM_PATH ?>services/services.php" class="btn btn-sm btn-outline-secondary">View
                      Services</a>
                  </div> -->
              </ul>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form class="form-horizontal form-label-left"
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data"
                method="post">

                <div class="form-group row ">
                  <label class="control-label col-md-1 col-sm-1 ">Description</label>
                  <div class="col-md-9 col-sm-9 ">
                    <input type="text" class="form-control" name="servicename" value="<?= @$servicename ?>"
                      placeholder="Reason for taking cash">
                    <span class="text-danger">
                      <?= @$messages['error_servicename']; ?>
                    </span>
                  </div>
                </div>
                <div class="form-group row ">
                  <label class="control-label col-md-1 col-sm-1 ">Amount (Rs)</label>
                  <div class="col-md-9 col-sm-9 ">
                    <input type="number" class="form-control" name="cost" value="<?= @$cost ?>" placeholder="1000.00">
                    <span class="text-danger">
                      <?= @$messages['error_cost']; ?>
                    </span>
                  </div>
                </div>
                <div class="col-md-12 col-sm-12  offset-md-1">

                  <button type="submit" name="action" value="creatediscount" class="btn btn-success">Submit</button>
                </div>

              </form>
            </div>



          </div>

        </div>
        <div class="col-md-12 col-sm-12  ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Expenses Table <small>  </small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                  <div class="row g-3">

                    <div class="col-sm">
                      <?php
                      //                $db = dbConn();
//                $sql = "SELECT DISTINCT Model FROM vehicle";
//                $result = $db->query($sql);
                      ?>
                      <select name="payementmethod" class="form-control">
                        <option value="">--Cash Out Type--</option>
                        <option value="stylist">Stylist</option>
                        <option value="management">Management</option>

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
                  $where .= " cashoutusertype='$payementmethod' AND";
                }
                if (!empty($from) && empty($to)) {
                  $where .= " Addeddate  = '$from' AND";
                }
                if (empty($from) && !empty($to)) {
                  $where .= " Addeddate  = '$to' AND";
                }
                if (!empty($from) && !empty($to)) {
                  $where .= " Addeddate  BETWEEN '$from' AND '$to' AND";
                }
                if ((empty($from)) && (empty($to))) {
                  $where .= " DATE(Addeddate) = CURDATE() AND";
                }
              


              

              if (!empty($where)) {
                $where = substr($where, 0, -3);
                $where = "  $where";
              }



              //        extract($_POST);
//        if ($_SERVER['REQUEST_METHOD'] == "POST" ) {
              extract($_POST);
              //    $CustomerId = $_GET['CustomerId'];
             
            $sql = "SELECT * FROM tbl_cashout INNER JOIN tbl_emp on tbl_cashout.Cashoutuserid = tbl_emp.EmpId where $where";
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
                      <th class="column-title">Stylist / Management </th>
                      <th class="column-title">Person Name </th>
                      <th class="column-title">Description </th>

                      <th class="column-title">Amount </th>


                    </tr>
                  </thead>
                  <?php
                  if ($where == null){
                     $sql = "SELECT * FROM tbl_cashout INNER JOIN tbl_emp on tbl_cashout.Cashoutuserid = tbl_emp.EmpId WHERE DATE(Addeddate) = CURDATE()";
                    $db = dbConn();
                    $results = $db->query($sql);
                  }
               
                  ?>

                  <tbody>
                    <?php
                    if ($results->num_rows > 0) {
                      $i = 1;
                      $totalamount = 0;
                      while ($row = $results->fetch_assoc()) {
                        ?>
                        <tr class="even pointer">

                          <td class=" ">
                            <?= $row['Addeddate'] ?>
                          </td>
                          <td class=" ">
                            <?= $row['cashoutusertype'] ?>
                          </td>
                          <td class=" ">
                            <?= $row['EmpTitle'] . " " . $row['EmpFName'] . " " . $row['EmpLName'] ?>
                          </td>
                          <td class=" ">
                            <?= $row['Reasonforcashout'] ?>
                          </td>
                          <td class=" ">
                            <?= $row['Amountcashout'] ?>
                          </td>
                          <?php $totalamount += $row['Amountcashout'] ?>
                          </td>
                        </tr>
                      <?php }
                    }else{?>
                      <tr><td colspan="4">No records For Today<td><tr><?php
                    } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4"><strong> Total Amount </strong>
                      </td>
                      <td><strong>
                        <?= number_format(@$totalamount, 2) ?> </strong>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>


            </div>
          </div>
        </div>
        <div class="row">

        </div>
      </div>
    </div>
    <!-- /page content -->
    <?php

    include '../footer.php'

      ?>