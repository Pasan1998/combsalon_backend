<?php
session_start();
include '../config.php';
include '../function.php';
// if (!isset($_SESSION['empid'])) {
//   // Redirect to the login page
//   header("Location: ../login.php");

// }
if (isset($_SESSION['EmpUserrole']) && $_SESSION['EmpUserrole'] == "management") {
  // The user has the "management" role
  // echo "User has the management role.";
} else {
  // Redirect to the login page or show an unauthorized message
  header("Location:http://localhost/salon/production/page_403.html");


}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
//check form submit method
if ($_SERVER['REQUEST_METHOD'] == "POST") {


  //seperate variables and values from the form
  extract($_POST);

  //data clean
  $sellingprice = cleanInput($sellingprice);
  $cost = cleanInput($cost);
  $servicename = cleanInput($servicename);

  //create array variable store validation messages
  $messages = array();

  //validate required fields

  if (empty($sellingprice)) {
    $messages['error_sellingprice'] = "Service Selling Price should not be empty!";
  }

  if (empty($cost)) {
    $messages['error_cost'] = "Service Selling Cost  should not be empty!";
  }

  if (empty($servicename)) {
    $messages['error_servicename'] = "Service Name should not be empty!";
  }

  if (!empty($servicename)) {
    $sql = "SELECT * FROM tbl_services WHERE ServiceName='$servicename'";
    $db = dbConn();
    $results = $db->query($sql);
    if ($results->num_rows > 0) {
      $messages['error_servicename'] = "This Service is already in Database !";
    }
  }

  if ((!empty($sellingprice) && (!empty($cost)))) {

    if ($sellingprice < $cost) {
      $messages['error_cost'] = "The Cost is higher than the Selling Price!";
    }

  }



  if (empty($messages)) {

    $db = dbConn();

    $AddUser = $_SESSION['EmpId'];

    $servicename = $db->real_escape_string($servicename);
    $after_cost_price_value = $sellingprice - $cost;
    $salary_cost = (($after_cost_price_value / 100) * 40);
    $profit = (($after_cost_price_value / 100) * 60);
    $service_cost = ($salary_cost + $cost);

    $AddDate = date('y-m-d');
    echo $sql = "INSERT INTO tbl_services(ServiceName,ServiceCost,ServicePrice, ServiceProfit, ServiceAddedDate, ServicesAddedUser,SalaryCost,UtilityCost) 
    VALUES ('$servicename','$service_cost','$sellingprice','$profit','$AddDate','$AddUser','$salary_cost','$cost')";
    $result = $db->query($sql);
    ?>

    <script>

      console.log('Success: Update query executed successfully');

      document.addEventListener('DOMContentLoaded', function () {

        Swal.fire({

          title: 'Success!',

        text: 'Service  Added to  the System', 

        icon: 'success', 

        confirmButtonText: 'OK'

          }).then(() => {
          

          window.location.href = 'services.php';

        });

       });

    </script>
    <?php
  }
}
?>
<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Salon | By Amitha </title>

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
            <a href="<?= SYSTEM_PATH ?>index.php" class="site_title"><i class="fa fa-paw"></i> <span>Salon by
                Amitha!</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic img-fluid">
              <img src="<?= SYSTEM_PATH ?>assets/users/<?= $_SESSION['EmpImage'] ?>" alt="..."
                class="img-circle img-fluid profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2><?php echo ucfirst($_SESSION['EmpFName']) ?></h2>
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
                <li><a href="<?= SYSTEM_PATH ?>discounts/creatediscounts.php"><i class="fa fa-credit-card"></i>
                    Discounts Management </a>

                </li>
                <li><a href="<?= SYSTEM_PATH ?>expenses/addexpenses.php"><i class="fa fa-money"></i>Expenses Management
                  </a></li>



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
                  <img class="img-fluid" src="<?= SYSTEM_PATH ?>assets/users/<?= $_SESSION['EmpImage'] ?>"
                    alt=""><?= $_SESSION['EmpTitle'] . " " . $_SESSION['EmpFName'] ?>
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">


                  <a class="dropdown-item" href="<?= SYSTEM_PATH ?>logout.php"><i class="fa fa-sign-out pull-right"></i>
                    Log Out</a>
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
              <h2>Add New Service <small></small></h2>

              <ul class="nav navbar-right panel_toolbox">
                <div class="btn-toolbar mb-2 mb-md-0">
                  <div class="btn-group ">
                    <a href="<?= SYSTEM_PATH ?>services/services.php" class="btn btn-sm btn-outline-secondary">View
                      Services</a>
                  </div>
              </ul>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form class="form-horizontal form-label-left"
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data"
                method="post">

                <div class="form-group row ">
                  <label class="control-label col-md-1 col-sm-1 ">Service Name</label>
                  <div class="col-md-9 col-sm-9 ">
                    <input type="text" class="form-control" name="servicename" value="<?= @$servicename ?>"
                      placeholder="Service Name">
                    <span class="text-danger">
                      <?= @$messages['error_servicename']; ?>
                    </span>
                  </div>
                </div>
                <div class="form-group row ">
                  <label class="control-label col-md-1 col-sm-1 ">Service Cost (Rs)</label>
                  <div class="col-md-9 col-sm-9 ">
                    <input type="number" class="form-control" name="cost" value="<?= @$cost ?>" placeholder="4000.00">
                    <span class="text-danger">
                      <?= @$messages['error_cost']; ?>
                    </span>
                  </div>
                </div>
                <div class="form-group row ">
                  <label class="control-label col-md-1 col-sm-1 ">Service Price (Rs)</label>
                  <div class="col-md-9 col-sm-9 ">
                    <input type="number" class="form-control" name="sellingprice" value="<?= @$sellingprice ?>"
                      placeholder="5000.00">
                    <span class="text-danger">
                      <?= @$messages['error_sellingprice']; ?>
                    </span>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12  offset-md-1">

                  <button type="submit" class="btn btn-success">Submit</button>
                </div>

              </form>
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