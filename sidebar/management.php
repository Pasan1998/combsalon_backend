<?php 
if ( @$admindashboard == "active"){

}else{
  include '../header.php'; 
}


?>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="<?= SYSTEM_PATH ?>index.php" class="site_title"><img src="<?= SYSTEM_PATH ?>assets/users/logo.jpg" class="img-fluid " style="width:50px;  border-radius: 40%;"></i> <span>Comb Salon
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
                  <?php 
                    $EmpId=$_SESSION['EmpId'];
                  ?>
                  <a class="dropdown-item" href="<?= SYSTEM_PATH ?>employers/profile.php?EmpId=<?= $EmpId?>"><i class="fa fa-sign-out pull-right"></i> Profile</a>
                </div>
              </li>

              
            </ul>
          </nav>
        </div>
      </div>
      
      <!-- /top navigation -->

 