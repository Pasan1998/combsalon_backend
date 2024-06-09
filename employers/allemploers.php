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
            <!-- <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group ">
                <a href="<?= SYSTEM_PATH ?>employers/addservice.php" class="btn btn-sm btn-outline-secondary">Add
                  Stylist</a>
              </div> -->
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
                        <?= ucwords($rowservices['EmpTitle']) . " " .ucwords( $rowservices['EmpFName']) . " " . ucwords($rowservices['EmpLName'] )?>
                      </td>
                      <td class=" ">
                        <?= $rowservices['EmpContact'] ?>
                      </td>
                      <td class=" ">
                        <?= ucwords($rowservices['EmpAdress']) ?>
                      </td>
                      <td class="a-right a-right ">
                        <?= ucwords($rowservices['EmpEmergencyContactPerson']) ?>
                      </td>
                      <td class="">
                        <?= $rowservices['EmpEmergencyContact'] ?>
                      </td>
                      <td class="">
                      <?php 
                                             
                                                 $status=$rowservices['EmpStatus'];
                                                if ($status == 1){
                                                    ?> 
                                                  
                                                    <button name="action" class="btn btn-round btn-success" value="deactive"> Active</button><?php
                                                }else{
                                                    ?>
                                                   
                                                      <button name="action" class="btn btn-round btn-danger" value="active" >Deative</button><?php 
                                                }
                                                ?>

                       
                      </td>        <?php 
                      
                      $genral_emp_id=$rowservices['EmpId'];
                      //$hash_Password = sha1($genral_emp_id);
                     
                      ?>           
                        <td class=" text-center " >
                          <button class="btn btn-primary" >
                          <a href="employer.php?EmpId=<?=$genral_emp_id ?>" style="color:white">View </a>
                        </button> 
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
<!-- /page content -->
<?php include '../footer.php';
ob_end_flush(); ?>