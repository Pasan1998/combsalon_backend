<?php
session_start();
include '../sidebar.php';


?>

	<!-- Switchery -->
	<link href="<?= SYSTEM_PATH ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
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
    <dive class="col-md-12 col-sm-12  ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Service Page</h2>
          <ul class="nav navbar-right panel_toolbox">
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group ">
                <a href="<?= SYSTEM_PATH ?>services/addservice.php" class="btn btn-sm btn-outline-secondary">Add
                  service</a>
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
                  <th class="column-title">Cost </th>
                  <th class="column-title">Price </th>

                  <th class="column-title ">serviceStatus
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
                        <?= $rowservices['ServiceCost'] ?>
                      </td>

                      <td class=" ">
                      
                        <?= $rowservices['ServicePrice'] ?>
                      </td>

                      
                      <td class="">
                      <form class="form-group">
                        <input type="checkbox" class="js-switch" checked /> Checked
                          <?= $rowservices['serviceStatus'] ?>
                  </form>
                  </td> 
                      
                      <td class=" text-center "><button class="form-group" name="action" value="edit" >
                        <a href="<?=SYSTEM_PATH ?>services/editservice.php?ServiceID=<?= $rowservices['ServicesID'] ?>">Edit </a>
                      </button>
                       <button name="action" value="delete">
                        <a href="<?=SYSTEM_PATH ?>services/deleteservice.php?ServiceID=<?= $rowservices['ServicesID'] ?>">
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
          </divs>


        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /page content -->
<?php include '../footer.php' ?>