<?php
session_start();
include '../sidebar.php';

// Check if user has the "management" role
if (isset($_SESSION['EmpUserrole']) && $_SESSION['EmpUserrole'] == "management") {
    // User has the management role
} else {
    // Redirect to the login page or show an unauthorized message
    header("Location:http://localhost/salon/production/page_403.html");
    exit();
}

// Pagination setup
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Database connection
$db = dbConn();

// Get total number of records
$sql_count = "SELECT COUNT(*) AS total FROM tbl_services";
$result_count = $db->query($sql_count);
$total_records = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

// Fetch records for the current page
$sqlservices = "SELECT * FROM tbl_services LIMIT $records_per_page OFFSET $offset";
$resultservices = $db->query($sqlservices);
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
                <a href="<?= SYSTEM_PATH ?>services/addservice.php" class="btn btn-sm btn-outline-secondary">Add Service</a>
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
                  <th class="column-title ">Service Status</th>
                  <th class="column-title ">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($resultservices->num_rows > 0) {
                  while ($rowservices = $resultservices->fetch_assoc()) {
                ?>
                    <tr class="even pointer">
                      <td class=" "><?= $rowservices['ServiceName'] ?></td>
                      <td class=" "><?= $rowservices['UtilityCost'] ?></td>
                      <td class=" "><?= $rowservices['SalaryCost'] ?></td>
                      <td class=" "><?= number_format(($rowservices['SalaryCost'] + $rowservices['UtilityCost'] ),2) ?></td>
                      <td class=" "><?= $rowservices['ServicePrice'] ?></td>
                      <td class=" "><?= $rowservices['ServiceProfit'] ?></td>
                      <td class="">
                        <?php 
                          $dis_id = $rowservices['ServicesID'];
                          $status = $rowservices['serviceStatus'];
                          if ($status == 1) { 
                        ?>
                          <input type="hidden" name="discountcodeidstatus" value="<?= $dis_id ?>";>
                          <button name="action" class="btn btn-round btn-success" value="deactive"> Active</button>
                        <?php 
                          } else { 
                        ?>
                          <input type="hidden" name="discountcodeidstatus" value="<?= $dis_id ?>";>
                          <button name="action" class="btn btn-round btn-danger" value="active">Deactive</button>
                        <?php 
                          } 
                        ?>
                      </td> 
                      <td class="text-center">
                        <button class="btn btn-info" name="action" value="edit">
                          <a href="<?= SYSTEM_PATH ?>services/editservice.php?ServiceID=<?= $rowservices['ServicesID'] ?>" style="color:white">Edit</a>
                        </button>
                        <button name="action" class="btn btn-danger" value="delete">
                          <a href="<?= SYSTEM_PATH ?>services/deleteservice.php?ServiceID=<?= $rowservices['ServicesID'] ?>" style="color:white">Delete</a>
                        </button>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <nav aria-label="Page navigation">
            <ul class="pagination">
              <?php if ($page > 1) { ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
              <?php } ?>
              <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
              <?php } ?>
              <?php if ($page < $total_pages) { ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
              <?php } ?>
            </ul>
          </nav>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->
<?php include '../footer.php'; ?>
