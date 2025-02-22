<?php
session_start();
include '../sidebar.php';
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
extract($_POST);
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
    echo $sql = "INSERT INTO tbl_cashout(Cashoutuserid, Amountcashout, Addeddate,Reasonforcashout,cashoutusertype) VALUES ('$AddUser','$cost',' $AddDate','$servicename','$user_type')";
    $result = $db->query($sql);
    ?>
    <script>
      // Swal.fire({
      //   title: 'Success!',
      //   text: 'Successfully Created User Account.',
      //   icon: 'success',
      //   confirmButtonText: 'OK'
      // }).then(() => {
      //   window.location.href = 'index.php'; // Redirect to success page
      // });
    </script>
    <?php
  }
}
?>
<?php
;
?>
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
        <form class="form-horizontal form-label-left" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
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
        <h2>Expenses Table <small> </small></h2>
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

                <input type="date" class="form-control" name="from" placeholder="Enter From Date"
                  max="<?php echo date('Y-m-d'); ?>" required="true">
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
            if ($where == null) {
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
              } else { ?>
                <tr>
                  <td colspan="4">No records For Today
                  <td>
                <tr><?php
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
<!-- /page content -->
<?php

include '../footer.php'

  ?>