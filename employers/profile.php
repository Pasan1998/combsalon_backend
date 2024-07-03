<?php
ob_start();
session_start();
include '../sidebar.php';
if (isset($_SESSION['EmpUserrole']) && ($_SESSION['EmpUserrole'] == "management"|| $_SESSION['EmpUserrole'] == "stylist")) {
    // The user has the "management" role
    // echo "User has the management role.";
  } else {
    // Redirect to the login page or show an unauthorized message
    header("Location:http://localhost/salon/production/page_403.html");
  
    
  }

?>

<?php 
extract($_GET);
 if ($_SERVER['REQUEST_METHOD'] == "GET") {
     $EmpId;
   
    $sql_select_emp_query="SELECT * FROM tbl_emp WHERE EmpId = '$EmpId'";
    $db = dbConn();
    $result_emp = $db->query($sql_select_emp_query);

 }

?>

<?php 
extract($_POST);
 if ($_SERVER['REQUEST_METHOD'] == "POST") {
  extract($_POST);
   $EmpIdSession;
   
    $sql_select_emp_query="SELECT * FROM tbl_emp WHERE EmpId = '$EmpIdSession'";
    $db = dbConn();
    $result_emp = $db->query($sql_select_emp_query);

    $messages = array();

    if (empty($oldPassword)) {
      $messages['error_oldPassword'] = "Current Password should not be empty!";
    }

    if (empty($newPassword)) {
      $messages['error_newPassword'] = "New Password should not be empty!";
    }

    if (empty($confirmPassword)) {
      $messages['error_confirmPassword'] = "Old Password Price should not be empty!";
    }

    if (!empty($newPassword)) {
      // Validate password strength
      if ( strlen($newPassword) < 2) {
        $messages['error_newPassword'] = "Password should be at least 3!";
      }
    }
  
    if ((!empty($newPassword)) && (!empty($confirmPassword))) {
  
      if ($newPassword != $confirmPassword) {
        $messages['error_newPassword'] = " Passwords are not match";
      }
    }

    if ((!empty($newPassword)) && (!empty($confirmPassword)) && (!empty($oldPassword)) ) {

      $db = dbConn();
      
      $hashedOldPWd = sha1($oldPassword);
      $updateingUserId = $_SESSION['EmpId'];

      $sqlupdateingUserId = "SELECT * FROM tbl_emp WHERE EmpId='$updateingUserId'";
      $resultsupdateingUserId = $db->query($sqlupdateingUserId);
      $rowupdateingUserId = $resultsupdateingUserId->fetch_assoc();

       $dbHashedPassword =  $rowupdateingUserId['EmpPassword'];

      if ($dbHashedPassword != $hashedOldPWd) {
        $messages['error_oldPassword'] = " Entered Current Password is not match";
      }

    }

    // Updating the Password
    if (empty($messages)) {
      $hashedNewPWd = sha1($newPassword);
       $sqlupdatePWD = "UPDATE tbl_emp set EmpPassword = '$hashedNewPWd'";
      $db->query($sqlupdatePWD);

      echo "<script>
      Swal.fire({
        title: 'Success!',
        text: 'Successfully Created User Account.',
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'profile.php?EmpId=" . $EmpIdSession . "'; // Redirect to success page
      });
    </script>";

      
    }


 }

?>

<!-- page content -->
<div class="right_col" role="main">
    


    <div class="row">
        <div class="col-md-12 col-sm-12  ">
            <div class="x_panel">
                
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 ">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>User Report <small>Activity report</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <!-- <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                                aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Settings 1</a>
                                                <a class="dropdown-item" href="#">Settings 2</a>
                                            </div>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li> -->
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                
                <?php
                if ($result_emp->num_rows > 0) {
                  $i = 1;
                    $row_emp = $result_emp->fetch_assoc();
                    ?>
                                <div class="x_content">
                                    <div class="col-md-3 col-sm-3  profile_left">
                                        <div class="profile_img">
                                            <div id="crop-avatar">
                                                <!-- Current avatar -->
                                                <img class="img-responsive avatar-view img-fluid" src="<?= SYSTEM_PATH ?>assets/users/<?= $row_emp['EmpImage'] ?>"
                                                    alt="Avatar" title="Change the avatar">
                                            </div>
                                        </div>
                                        <h3><?= ucwords($row_emp['EmpTitle']) . " ". ucwords($row_emp['EmpFName']) . " ". ucwords($row_emp['EmpLName'])  ?> </h3>

                                        <ul class="list-unstyled user_data">
                                            <li><i class="fa fa-map-marker user-profile-icon"></i> <?=  ucwords($row_emp['EmpAdress']) ?>
                                            </li>

                                            <li>
                                                <i class="fa fa-briefcase user-profile-icon"></i> <?=  ucwords($row_emp['EmpGender']) ?>
                                            </li>

                                            <li class="m-top-xs">
                                                <i class="fa fa-external-link user-profile-icon"></i>
                                              <?= ucwords($row_emp['EmpUserrole']) ?>
                                            </li>
                                            <li class="m-top-xs">
                                                <i class="fa fa-external-link user-profile-icon"></i> DOB:
                                              <?= ucwords($row_emp['EmpDOB']) ?>
                                            </li>
                                            <li class="m-top-xs">
                                                <i class="fa fa-external-link user-profile-icon"></i> NIC:
                                              <?= ucwords($row_emp['EmpNIC']) ?>
                                            </li>
                                            <li class="m-top-xs">
                                                <i class="fa fa-external-link user-profile-icon"></i>Emergency Contact Person:
                                              <?= ucwords($row_emp['EmpEmergencyContactPerson']) ?>
                                            </li>
                                            <li class="m-top-xs">
                                                <i class="fa fa-external-link user-profile-icon"></i> Emergency Contact Number:
                                              <?= ucwords($row_emp['EmpEmergencyContact']) ?>
                                            </li>
                                        </ul>


                                        <br />



                                    </div>
                                    <div class="col-md-9 col-sm-9 ">

                                        <div class="profile_title">
                                            <div class="col-md-6">
                                                <h2>Sales Contribution Report</h2>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="" class="pull-right"
                                                    style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                    <?php 
                                                     $current_day = date('Y-m-d');
                                                     $date_object = new DateTime($current_day);
                                                     $month_name_currentdate = $date_object->format('F');
                                                     $fourteendays_before =date('Y-m-d', strtotime('-6 days', strtotime($current_day)));
                                                     $date_object_before_days = new DateTime($fourteendays_before);
                                                     $month_name_before_date = $date_object->format('F');
                                                    ?>
                                                    <span><?= $month_name_before_date." ".$fourteendays_before ?> - <?= $month_name_currentdate." ".$current_day ?></span> <b
                                                        class="caret"></b>
                                                        <div class="btn-group ml-1">
                <!-- <a href="<?= SYSTEM_PATH ?>employers/sales_contribution_details.php?EmpId=<?= $EmpId ?>" class="btn btn-sm btn-outline-secondary"> More Filter</a> -->
              </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- start of user-activity-graph -->
                                        <canvas id="myChart2" style="width:100%;height: 100%"></canvas>
                                       
                                        <!-- end of user-activity-graph -->
                                        <div class="profile_title">
                                            <div class="col-md-6">
                                                <h2>Cash out Report</h2>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="reportrange" class="pull-right"
                                                    style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                    <span>December 30, 2014 - January 28, 2015</span> <b
                                                        class="caret"></b>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- start of user-activity-graph -->
                                        <canvas id="myChart4" style="width:100%;height: 100%"></canvas>
                                       
                                        <!-- end of user-activity-graph -->

                                      
                                       
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php }?>
                </div>
            </div>
        </div>
        <div class="col-md-12 ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Reset Password <small></small></h2>



              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form class="form-horizontal form-label-left"
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data"
                method="post">

                <div class="form-group row ">
                  <label class="control-label col-md-1 col-sm-1 ">Old Password</label>
                  <div class="col-md-9 col-sm-9 ">
                    <input type="text" class="form-control" name="oldPassword" value="<?= @$oldPassword ?>"
                      placeholder="Old Password">
                    <span class="text-danger">
                      <?= @$messages['error_oldPassword']; ?>
                    </span>
                  </div>
                </div>
                <div class="form-group row ">
                  <label class="control-label col-md-1 col-sm-1 ">New Password</label>
                  <div class="col-md-9 col-sm-9 ">
                    <input type="text" class="form-control" name="newPassword" value="<?= @$newPassword ?>" placeholder="New Password">
                    <span class="text-danger">
                      <?= @$messages['error_newPassword']; ?>
                    </span>
                  </div>
                </div>
                <div class="form-group row ">
                  <label class="control-label col-md-1 col-sm-1 ">Confirm Password</label>
                  <div class="col-md-9 col-sm-9 ">
                    <input type="text" class="form-control" name="confirmPassword" value="<?= @$confirmPassword ?>"
                      placeholder="Confirm Password">
                    <span class="text-danger">
                      <?= @$messages['error_confirmPassword']; ?>
                    </span>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12  offset-md-1">
                  <?php 
                   $EmpIdSession = $_SESSION['EmpId'] ;
                  ?>
                  <input type="hidden" name="EmpIdSession" value="<?=@$EmpIdSession?>">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>

              </form>
            </div>
          </div>
        </div>
    </div>
</div>
</div>
<!-- sales report php sql code start -->
<?php
//        SELECT op.productid, imi.productid, tp.ProductID , tp.ProductCategory , imi.price FROM `orderproducts` op INNER JOIN tbl_imie imi on op.productid= imi.productid INNER JOIN tbl_products tp on op.productid=tp.ProductID;
        //$sqldiscount = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleAmount) AS total_sale FROM tbl_sales WHERE SaleDate >= CURDATE() - INTERVAL 6 DAY GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
        
        $sql_sevenday_sales=" SELECT date_range.date AS sale_day, COALESCE(SUM(s.SaleServiceSale), 0) AS total_sale
        FROM (
            SELECT CURDATE() - INTERVAL n DAY AS date
            FROM (
                SELECT @row := @row - 1 AS n
                FROM information_schema.columns, (SELECT @row := 14) r
                LIMIT 14
            ) dates
        ) date_range
        LEFT JOIN tbl_sales_services s ON date_range.date = DATE(s.SaleServiceAddedDate)
        WHERE s.EmplyoeeID = '$EmpId'
        GROUP BY date_range.date
        ORDER BY date_range.date DESC;
        ";
        $db = dbConn();
        $result_sevenday_sales = $db->query($sql_sevenday_sales);

        $data_labeldiscount = array();
        $data_valuediscount = array();

        while ($row_sevenday_sales = $result_sevenday_sales->fetch_assoc()) {
            $data_labeldiscount[] = $row_sevenday_sales['total_sale'];
            $data_valuediscount[] = $row_sevenday_sales['sale_day'];
        }
         "<br>";
          "'" . implode("','", $data_valuediscount) . "'";
          implode(",", $data_labeldiscount);
        ?>
<!-- sales report php sql code end -->


<!-- start of profit calculation -->
<?php
//        SELECT op.productid, imi.productid, tp.ProductID , tp.ProductCategory , imi.price FROM `orderproducts` op INNER JOIN tbl_imie imi on op.productid= imi.productid INNER JOIN tbl_products tp on op.productid=tp.ProductID;
        //$sqldiscount = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleAmount) AS total_sale FROM tbl_sales WHERE SaleDate >= CURDATE() - INTERVAL 6 DAY GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
        
        $sql_sevenday_sales=" SELECT date_range.date AS sale_day, COALESCE(SUM(s.Amountcashout), 0) AS total_sale
        FROM (
            SELECT CURDATE() - INTERVAL n DAY AS date
            FROM (
                SELECT @row := @row - 1 AS n
                FROM information_schema.columns, (SELECT @row := 14) r
                LIMIT 14
            ) dates
        ) date_range
        LEFT JOIN tbl_cashout s ON date_range.date = DATE(s.Addeddate)
        WHERE s.Cashoutuserid = '$EmpId'
        GROUP BY date_range.date
        ORDER BY date_range.date DESC;
        ";
        $db = dbConn();
        $result_sevenday_cashout = $db->query($sql_sevenday_sales);

        $data_label_cashout = array();
        $data_value_cashout = array();

        while ($row_sevenday_cashout = $result_sevenday_cashout->fetch_assoc()) {
            $data_label_cashout[] = $row_sevenday_cashout['total_sale'];
            $data_value_cashout[] = $row_sevenday_cashout['sale_day'];
        }
         "<br>";
          "'" . implode("','", $data_value_cashout) . "'";
          implode(",", $data_label_cashout);
        ?>
<!-- End of profit calculation -->
<script>
    const ctx = document.getElementById('myChart2');

  //   new Chart(ctx, {
  //     type: 'bar',
  //   data: {
  //     labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
  //   datasets: [{
  //     label: '# of Votes',
  //   data: [12, 19, 3, 5, 2, 3],
  //   borderWidth: 1
  //     }]
  //   },
  //   options: {
  //     scales: {
  //     y: {
  //     beginAtZero: true
  //       }
  //     }
  //   }
  // });

    new Chart(ctx, {
      type: 'bar',
    data: {
      labels: [<?= "'" . implode("','", $data_valuediscount) . "'" ?>],
    datasets: [{
      label: '# of Votes',
    data: [<?=  implode(",", $data_labeldiscount) ?>],
    borderWidth: 2,
    borderColor: 'rgb(75, 192, 255)', 
    fill: false,
    tension: 0.1
      }]
    },
    options: {
      scales: {
      y: {
      beginAtZero: true
        }
      }
    }
  });


</script>
<script>
    const ctx1 = document.getElementById('myChart4');
    new Chart(ctx1, {
      type: 'bar',
    data: {
      labels: [<?= "'" . implode("','", $data_value_cashout) . "'" ?>],
    datasets: [{
      label: '# of Votes',
    data: [<?=  implode(",", $data_label_cashout) ?>],
    borderWidth: 2,
    borderColor: 'rgb(75, 192, 255)', 
    fill: false,
    tension: 0.1
      }]
    },
    options: {
      scales: {
      y: {
      beginAtZero: true
        }
      }
    }
  });


</script>

<!-- /page content -->
<?php include '../footer.php' ?>