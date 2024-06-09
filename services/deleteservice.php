<?php
session_start();
include '../config.php';
include '../function.php';
// if (!isset($_SESSION['empid'])) {
//   // Redirect to the login page
//   header("Location: ../login.php");
   
// }

?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php


//check form submit method
extract($_GET);
// if ($_SERVER['REQUEST_METHOD'] == "GET") {

//   $ServiceID;

//  $sqleditservice = "DELETE  FROM tbl_services where ServicesID = '$ServiceID' ";
//   $db = dbConn();
//   $resulteditservice = $db->query($sqleditservice);
//   //seperate variables and values from the form
// if ($resulteditservice) {

//   header("Location:services.php");

// }else{
//   echo "Something Went Wrong";
// }

// }


?>

<!-- /page content -->


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
            <a href="<?= SYSTEM_PATH ?>index.php" class="site_title"><i class="fa fa-paw"></i> <span>Salon by
                Amitha!</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="<?= SYSTEM_PATH ?>production/images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2>
                <?php echo ucfirst($_SESSION['EmpFName']) ?>
              </h2>
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

                <li><a href="<?= SYSTEM_PATH ?>services/services.php"><i class="fa fa-home"></i> Services </a>

                </li>
                <li><a href="<?= SYSTEM_PATH ?>employers/allemploers.php"><i class="fa fa-home"></i> Stylists </a>

                </li>
                <li><a href="<?= SYSTEM_PATH ?>reports/salesreport.php"><i class="fa fa-home"></i> Reports </a>

                </li>
                <li><a href="<?= SYSTEM_PATH ?>users/allUsers.php"><i class="fa fa-home"></i> Users Management </a>

                </li>


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
                  <img src="<?= SYSTEM_PATH ?>production/images/img.jpg" alt="">
                  <?= $_SESSION['EmpTitle'] . " " . $_SESSION['EmpFName'] ?>
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="javascript:;"> Profile</a>
                  <a class="dropdown-item" href="javascript:;">
                    <span class="badge bg-red pull-right">50%</span>
                    <span>Settings</span>
                  </a>
                  <a class="dropdown-item" href="javascript:;">Help</a>
                  <a class="dropdown-item" href="<?= SYSTEM_PATH ?>logout.php"><i class="fa fa-sign-out pull-right"></i>
                    Log Out</a>
                </div>
              </li>


            </ul>
            </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">

        <!-- <div class="col-md-12 ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Update Service <small></small></h2>

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
                <input type="hidden" name="ServiceID" value="<?= $ServiceID ?>">
                <div class="col-md-12 col-sm-12  offset-md-1">

                  <button type="submit" class="btn btn-success" name="action" value="edit">Update</button>
                  <?php
                  if (@$service_status == 1) {
                    ?>
                    <button type="submit" class="btn btn-danger" name="action" value="deactivate">De-Activate</button>
                    <?php
                  } else {
                    ?>
                    <button type="submit" class="btn btn-success" name="action" value="activate">Activate</button>
                    <?php
                  }
                  ?>

                </div>

              </form>
            </div>
          </div>
        </div> -->

        <script>
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-success",
    cancelButton: "btn btn-danger"
  },
  buttonsStyling: false
});

swalWithBootstrapButtons
  .fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel!",
    reverseButtons: true
  })
  .then((result) => {
    if (result.isConfirmed) {
      // Perform the action when "Yes, delete it!" is clicked
      // For example, you can make an AJAX request to delete the file
      // Replace the following line with your actual action
      //console.log("Deleting the file...");
      const capturedValue = getParameterValueFromURL('ServiceID');
      window.location.href = 'Confirmdeletion.php?ServiceID=' + capturedValue;

     
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      swalWithBootstrapButtons.fire({
        title: "Cancelled",
        text: "Your imaginary file is safe :)",
        icon: "error",
        
      }).then(() => {
                window.location.href = 'services.php'; // Redirect to success page
            });
    }
  });
  function getParameterValueFromURL(parameterName) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(parameterName);
}
</script>





        <div class="row">
        </div>
      </div>
    </div>
    <!-- /page content -->
    <?php

    include '../footer.php'

      ?>