<?php
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
          <h2>Services List</h2>
          <ul class="nav navbar-right panel_toolbox">
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group ">
                <a href="<?= SYSTEM_PATH ?>services/addservice.php" class="btn btn-sm btn-outline-secondary">Add
                  Service</a>
              </div>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">



          <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">

                  <th class="column-title">Service Name </th>
                  <th class="column-title">Utility Cost </th>
                  <th class="column-title">Salary Cost </th>
                  <th class="column-title">Total Cost </th>
                  <th class="column-title">Price </th>
                  <th class="column-title">Profit </th>

                  <th class="column-title ">Service Status
                  </th>
                  <th class="column-title ">Action</span>
                  </th>

                </tr>
              </thead>

              <tbody>
                <?php
                $sqlservices = "SELECT * FROM tbl_services  ";
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
                        <?= $rowservices['ServiceName'] ?>
                      </td>

                      <td class=" ">
                        <?= $rowservices['UtilityCost'] ?>
                      </td>

                      <td class=" ">
                        <?= $rowservices['SalaryCost'] ?>
                      </td>

                      <td class=" ">
                        <?= number_format(($rowservices['SalaryCost'] + $rowservices['UtilityCost'] ),2)?>
                      </td>
             
                      <td class=" ">
                        <?= $rowservices['ServicePrice'] ?>
                      </td>

                      <td class=" ">
                      
                        <?= $rowservices['ServiceProfit'] ?>
                      </td>

                      
                      <td class="">
                          <?php 
                                            $dis_id=$rowservices['ServicesID'];
                                             $status=$rowservices['serviceStatus'];
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
                      
                      <td class=" text-center "><button class=" btn btn-info" name="action" value="edit" >
                        <a href="<?=SYSTEM_PATH ?>services/editservice.php?ServiceID=<?= $rowservices['ServicesID'] ?>" style="color:white">Edit </a>
                      </button>
                       <button name="action" class="btn btn-danger" value="delete">
                        <a href="<?=SYSTEM_PATH ?>services/deleteservice.php?ServiceID=<?= $rowservices['ServicesID'] ?>" style="color:white">
                        Delete </a>
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
<?php include '../footer.php' ?>