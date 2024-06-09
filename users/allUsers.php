<?php
ob_start();

session_start();
include '../sidebar.php';

if (isset($_SESSION['EmpUserrole']) && $_SESSION['EmpUserrole'] == "management") {
  // The user has the "management" role
  // echo "User has the management role.";
} else {
  // Redirect to the login page or show an unauthorized message
  header("Location:http://localhost/salon/production/page_403.html");

  
}


?>
<?php
extract($_POST);

if ($_SERVER['REQUEST_METHOD'] == "POST" && $action == 'deactive') {
    $discountcodeidstatus;
    $db=dbConn();
    $AddUser = $_SESSION['EmpId'];
    $AddDate = date('y-m-d');

    $sql_check_Managament="SELECT * FROM tbl_emp WHERE EmpUserrole ='management' and EmpStatus = 1";
    $result_check_Managament = $db->query($sql_check_Managament);
    if($result_check_Managament->num_rows == 1) {

      ?>
    <script>
           document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Warning!',
        text: 'One Management Account Should always have to fucntion the system',
        icon: 'warning',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = 'allusers.php'; // Redirect to success page
    });
});

        </script><?php
    }else{
      $sqldeactivate="UPDATE tbl_emp SET EmpStatus = '2', updateDate = '$AddDate', UpdateUser = '$AddUser' WHERE EmpId = '$discountcodeidstatus'";
    $resultdeactivate = $db->query($sqldeactivate);?>
    <script>
           document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Success!',
        text: 'Successfully Deactivated  User Account',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = 'allusers.php'; // Redirect to success page
    });
});

        </script><?php

    }

    
}
?>
<!-- stylist deactive start -->

<?php
extract($_POST);

if ($_SERVER['REQUEST_METHOD'] == "POST" && $action == 'deactivestaff') {
    $discountcodeidstatus;
    $db=dbConn();
    $AddUser = $_SESSION['EmpId'];
    $AddDate = date('y-m-d');

    $sql_check_Staff="SELECT * FROM tbl_emp WHERE EmpUserrole ='stylist' and EmpStatus = 1";
    $result_check_Staff = $db->query($sql_check_Staff);
    if($result_check_Staff->num_rows == 1) {

      ?>
    <script>
           document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Warning!',
        text: 'One Staff Account Should always have to fucntion the system',
        icon: 'warning',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = 'allusers.php'; // Redirect to success page
    });
});

        </script><?php
    }else{
      $sqldeactivate="UPDATE tbl_emp SET EmpStatus = '2', updateDate = '$AddDate', UpdateUser = '$AddUser' WHERE EmpId = '$discountcodeidstatus'";
    $resultdeactivate = $db->query($sqldeactivate);?>
    <script>
           document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Success!',
        text: 'Successfully Deactivated  User Account',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = 'allusers.php'; // Redirect to success page
    });
});

        </script><?php

    }

    
}
?>

<!-- stylist deactive end-->
<?php
extract($_POST);

if ($_SERVER['REQUEST_METHOD'] == "POST" && $action == 'active') {
    $discountcodeidstatus;
    $db=dbConn();
    $AddUser = $_SESSION['EmpId'];
    $AddDate = date('y-m-d');
    $sqlactivate="UPDATE tbl_emp SET EmpStatus = '1', updateDate = '$AddDate', UpdateUser = '$AddUser' WHERE EmpId = '$discountcodeidstatus'";
    $resultactivate = $db->query($sqlactivate);
    ?>
    <script>
           document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Success!',
        text: 'Successfully Activated Discount code',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = 'allusers.php'; // Redirect to success page
    });
});

        </script><?php
    ?>
            
<?php
}
?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <!-- <h3>Plain Page</h3> -->
      </div>
    </div>
  </div>
  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12  ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Stylist's List</h2>
          <ul class="nav navbar-right panel_toolbox">
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group ">
                <a href="<?= SYSTEM_PATH ?>users/addUser.php" class="btn btn-sm btn-outline-secondary">Add
                  User</a>
              </div>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">



          <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
              <thead>
                <tr class="headings">

                  <th class="column-title">Stylist Name </th>
                  <th class="column-title">Mobile Number </th>
                  <th class="column-title">Address </th>
                  <th class="column-title">Emegerncy Contact Person </th>
                  <th class="column-title no-link last"><span class="nobr">Emergency Contact Number</span>
                  <th class="column-title">Status </th>
                  </th>
                  <th class="column-title no-link last text-center"><span class="nobr">Action</span>
                  </th>

                </tr>
              </thead>

              <tbody>
                <?php
                $sqlservices = "SELECT * FROM tbl_emp where EmpUserrole = 'stylist' ";
                $db = dbConn();
                $resultservices = $db->query($sqlservices);

                ?>

                <?php
                if ($resultservices->num_rows > 0) {
                  $i = 1;
                  while ($rowservices = $resultservices->fetch_assoc()) {
                    ?>
                    <tr class="even pointer">

                      <td class=" ">
                        <?= ucwords( $rowservices['EmpTitle'] ). " " . ucwords( $rowservices['EmpFName'] ). " " . ucwords( $rowservices['EmpLName']) ?>
                      </td>
                      <td class=" ">
                        <?= ucwords( $rowservices['EmpContact'] )?>
                      </td>
                      <td class=" ">
                        <?= ucwords($rowservices['EmpAdress'] )?>
                      </td>
                      <td class="a-right a-right ">
                        <?= ucwords( $rowservices['EmpEmergencyContactPerson']) ?>
                      </td>
                      <td class="">
                        <?= $rowservices['EmpEmergencyContact'] ?>
                      </td>
                      <td class="text-end">
                                            
                                            <?php 
                                            $dis_id=$rowservices['EmpId'];
                                             $status=$rowservices['EmpStatus'];
                                            if ($status == 1){
                                                ?> 
                                                <input type="hidden" name="discountcodeidstatus" value="  <?= $dis_id ?> ";>
                                                <button name="action" class="btn btn-round btn-success" value="deactive"> Active</button><?php
                                            }else{
                                                ?>
                                                 <input type="hidden" name="discountcodeidstatus" value="  <?= $dis_id ?> ";>
                                                  <button name="action" class="btn btn-round btn-danger" value="active" >Deative</button><?php 
                                            }
                                            ?>
                                                                                                                                                         
                                     
                                    </td>
                 
                                    <td class="text-end">
                                        <form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                            <?php 
                                            $dis_id=$rowservices['EmpId'];
                                             $status=$rowservices['EmpStatus'];
                                            if ($status == 1){
                                                ?> 
                                                <input type="hidden" name="discountcodeidstatus" value="  <?= $dis_id ?> ";>
                                                <button name="action" class="btn  btn-danger" value="deactivestaff"> Click to Deactive</button><?php
                                            }else{
                                                ?>
                                                 <input type="hidden" name="discountcodeidstatus" value="  <?= $dis_id ?> ";>
                                                  <button name="action" class="btn  btn-success" value="active" >Click To Active</button><?php 
                                            }
                                            ?>
                                                                                                                                                         
                                      </form>
                                    </td>
                    </tr>
                    <?php
                    $i++;
                  }
                }
                ?>

              </tbody>
            </table>
          </div>


        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12  ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Management Lists</h2>
          <ul class="nav navbar-right panel_toolbox">
            
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">



          <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
              <thead>
                <tr class="headings">

                  <th class="column-title">Stylist Name </th>
                  <th class="column-title">Mobile Number </th>
                  <th class="column-title">Address </th>
                  <th class="column-title">Emegerncy Contact Person </th>
                  <th class="column-title no-link last"><span class="nobr">Emergency Contact Number</span>
                  <th class="column-title">Status </th>
                  </th>
                  <th class="column-title no-link last text-center"><span class="nobr">Action</span>
                  </th>

                </tr>
              </thead>

              <tbody>
                <?php
                $sqlservices = "SELECT * FROM tbl_emp where EmpUserrole = 'management' ";
                $db = dbConn();
                $resultservices = $db->query($sqlservices);

                ?>

                <?php
                if ($resultservices->num_rows > 0) {
                  $i = 1;
                  while ($rowservices = $resultservices->fetch_assoc()) {
                    ?>
                    <tr class="even pointer">

                      <td class=" ">
                        <?= ucfirst( $rowservices['EmpTitle'] ). " " . ucfirst($rowservices['EmpFName']) . " " . ucfirst( $rowservices['EmpLName']) ?>
                      </td>
                      <td class=" ">
                        <?=ucfirst( $rowservices['EmpContact'] )?>
                      </td>
                      <td class=" ">
                        <?= ucfirst( $rowservices['EmpAdress']) ?>
                      </td>
                      <td class="a-right a-right ">
                        <?= ucfirst($rowservices['EmpEmergencyContactPerson'] )?>
                      </td>
                      <td class="">
                        <?= ucfirst($rowservices['EmpEmergencyContact']) ?>
                      </td>
                      <td class="text-end">
                                            
                                                <?php 
                                                $dis_id=$rowservices['EmpId'];
                                                 $status=$rowservices['EmpStatus'];
                                                if ($status == 1){
                                                    ?> 
                                                    <input type="hidden" name="discountcodeidstatus" value="  <?= $dis_id ?> ";>
                                                    <button name="action" class="btn btn-round btn-success" value="deactive"> Active</button><?php
                                                }else{
                                                    ?>
                                                     <input type="hidden" name="discountcodeidstatus" value="  <?= $dis_id ?> ";>
                                                      <button name="action" class="btn btn-round btn-danger" value="active" >Deative</button><?php 
                                                }
                                                ?>
                                                                                                                                                             
                                         
                                        </td>
                     
                                        <td class="text-end">
                                            <form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                <?php 
                                                $dis_id=$rowservices['EmpId'];
                                                 $status=$rowservices['EmpStatus'];
                                                if ($status == 1){
                                                    ?> 
                                                    <input type="hidden" name="discountcodeidstatus" value="  <?= $dis_id ?> ";>
                                                    <button name="action" class="btn  btn-danger" value="deactive"> Click to Deactive</button><?php
                                                }else{
                                                    ?>
                                                     <input type="hidden" name="discountcodeidstatus" value="  <?= $dis_id ?> ";>
                                                      <button name="action" class="btn  btn-success" value="active" >Click To Active</button><?php 
                                                }
                                                ?>
                                                                                                                                                             
                                          </form>
                                        </td>
                      
                    </tr>
                    <?php
                    $i++;
                  }
                }
                ?>

              </tbody>
            </table>
          </div>


        </div>
      </div>
    </div>
  </div>

</div>
</div>


</div>
<!-- /page content -->
<?php include '../footer.php';

ob_end_flush();?>