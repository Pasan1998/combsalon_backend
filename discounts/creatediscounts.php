<?php
session_start();
// if (!isset($_SESSION['empid'])) {
//   // Redirect to the login page
//   header("Location: ../login.php");

// }
// include '../config.php';
// include '../function.php';
include '../sidebar.php';

if (isset($_SESSION['EmpId'])) {

} else {
  header("Location: " . SYSTEM_PATH . "login.php");

}

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
extract($_POST);

if ($_SERVER['REQUEST_METHOD'] == "POST" && $action == 'createcode') {


  //seperate variables and values from the form
  extract($_POST);

  //data clean
  $discountname = cleanInput($discountname);
  $percentage = cleanInput($percentage);


  //create array variable store validation messages
  $messages = array();

  //validate required fields

  if (empty($discountname)) {
    $messages['error_discountname'] = "Discount  Name  should not be empty!";
  }

  if (empty($percentage)) {
    $messages['error_percentage'] = "Discount Percentage  should not be empty!";
  }


  if (!empty($discountname)) {
    $sql = "SELECT * FROM tbl_discountscodes WHERE Discountcodename='$discountname'";
    $db = dbConn();
    $results = $db->query($sql);
    if ($results->num_rows > 0) {
      $messages['error_discountname'] = "This Discount Code is already in use!";
    }
  }

  if (!empty($percentage)) {
    if ($percentage <= 0) {
      $messages['error_percentage'] = "Discount Percentage  should not be Minus value or zero!";
    }
  }


  if (empty($messages)) {

    $db = dbConn();

    $AddUser = $_SESSION['EmpId'];

    $AddDate = date('y-m-d');
    $sql = "INSERT INTO tbl_discountscodes(Discountcodename, Discountcodepercentage, AddedUser, AddedDate) 
        VALUES ('$discountname','$percentage',' $AddUser',' $AddDate')";
    $result = $db->query($sql);
    ?>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
          title: 'Success!',
          text: 'Successfully Created User Account.',
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.href = 'creatediscounts.php'; // Redirect to success page
        });
      });

    </script>
    <?php
  }
}
?>
<?php
extract($_POST);

if ($_SERVER['REQUEST_METHOD'] == "POST" && $action == 'deactive') {
  $discountcodeidstatus;
  $db = dbConn();
  $AddUser = $_SESSION['EmpId'];
  $AddDate = date('y-m-d');
  $sqldeactivate = "UPDATE tbl_discountscodes SET DiscountStatus = '2', updatedate = '$AddDate', UpdatedUser = '$AddUser' WHERE Discountscodeid = '$discountcodeidstatus'";
  $resultdeactivate = $db->query($sqldeactivate); ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      Swal.fire({
        title: 'Success!',
        text: 'Successfully Deactivated Discount code',
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'creatediscounts.php'; // Redirect to success page
      });
    });

  </script>
  <?php
}
?>
<?php
extract($_POST);

if ($_SERVER['REQUEST_METHOD'] == "POST" && $action == 'active') {
  $discountcodeidstatus;
  $db = dbConn();
  $AddUser = $_SESSION['EmpId'];
  $AddDate = date('y-m-d');
  $sqlactivate = "UPDATE tbl_discountscodes SET DiscountStatus = '1', updatedate = '$AddDate', UpdatedUser = '$AddUser' WHERE Discountscodeid = '$discountcodeidstatus'";
  $resultactivate = $db->query($sqlactivate);
  ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      Swal.fire({
        title: 'Success!',
        text: 'Successfully Activated Discount code',
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'creatediscounts.php'; // Redirect to success page
      });
    });

  </script><?php
  ?>

  <?php
}
?>

<!-- page content -->
<div class="right_col" role="main">

  <div class="col-md-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Add New Discount Code <small></small></h2>

        <ul class="nav navbar-right panel_toolbox">
        </ul>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form class="form-horizontal form-label-left" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
          enctype="multipart/form-data" method="post">

          <div class="form-group row ">
            <label class="control-label col-md-1 col-sm-1 ">Discount Name</label>
            <div class="col-md-9 col-sm-9 ">
              <input type="text" class="form-control" name="discountname" value="<?= @$discountname ?>"
                placeholder="Discount Name" id="textInput" oninput="capitalizeInput()">
              <span class="text-danger">
                <?= @$messages['error_discountname']; ?>
              </span>
            </div>
          </div>
          <div class="form-group row ">
            <label class="control-label col-md-1 col-sm-1 ">Discount Percentage</label>
            <div class="col-md-9 col-sm-9 ">
              <input type="number" class="form-control" name="percentage" value="<?= @$percentage ?>"
                placeholder="0.00%">
              <span class="text-danger">
                <?= @$messages['error_percentage']; ?>
              </span>
            </div>
          </div>


          <div class="col-md-12 col-sm-12  offset-md-1">

            <button type="submit" class="btn btn-success" name="action" value="createcode">Submit</button>
          </div>

        </form>
      </div>
    </div>
  </div>


  <div class="col-md-12 col-sm-12  ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Create Discount Codes <small></small></h2>
        <ul class="nav navbar-right panel_toolbox">

        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">

        <!-- <p>Add class <code>bulk_action</code> to table for bulk actions options on row select</p> -->

        <div class="table-responsive">
          <table class="table table-striped jambo_table bulk_action">
            <thead>
              <tr class="headings">

                <th class="column-title">Discount Code </th>
                <th class="column-title">Discoutn Percentage </th>
                <th class="column-title">Status</th>
                <th class="column-title">Action</th>
                <th class="column-title">Created Date</th>


              </tr>
            </thead>
            <?php
            $sqlallcodes = "SELECT * FROM tbl_discountscodes  ";
            $db = dbConn();
            $resultallcodes = $db->query($sqlallcodes);
            ?>

            <tbody>
              <?php
              if ($resultallcodes->num_rows > 0) {
                $i = 1;
                while ($rowallcodes = $resultallcodes->fetch_assoc()) {
                  ?>
                  <tr class="even pointer">

                    <td class=" "><?= $rowallcodes['Discountcodename'] ?></td>
                    <td class=" "><?= $rowallcodes['Discountcodepercentage'] ?>%</td>
                    <td class="text-end">

                      <?php
                      $dis_id = $rowallcodes['Discountscodeid'];
                      $status = $rowallcodes['DiscountStatus'];
                      if ($status == 1) {
                        ?>
                        <input type="hidden" name="discountcodeidstatus" value="  <?= $dis_id ?> " ;>
                        <button name="action" class="btn btn-round btn-success" value="deactive"> Active</button><?php
                      } else {
                        ?>
                        <input type="hidden" name="discountcodeidstatus" value="  <?= $dis_id ?> " ;>
                        <button name="action" class="btn btn-round btn-danger" value="active">Deative</button><?php
                      }
                      ?>


                    </td>

                    <td class="text-end">
                      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <?php
                        $dis_id = $rowallcodes['Discountscodeid'];
                        $status = $rowallcodes['DiscountStatus'];
                        if ($status == 1) {
                          ?>
                          <input type="hidden" name="discountcodeidstatus" value="  <?= $dis_id ?> " ;>
                          <button name="action" class="btn btn-danger" value="deactive"> Click to Deactivate</button><?php
                        } else {
                          ?>
                          <input type="hidden" name="discountcodeidstatus" value="  <?= $dis_id ?> " ;>
                          <button name="action" class="btn btn-success" value="active">Click to Activate</button><?php
                        }
                        ?>

                      </form>
                    </td>
                    <td class=" "><?= $rowallcodes['AddedDate'] ?></td>


                  </tr>
                <?php }
              } ?>

            </tbody>
          </table>
        </div>


      </div>
    </div>
  </div>





</div>

<!-- /page content -->

<script>
  function capitalizeInput() {
    var inputElement = document.getElementById('textInput');
    inputElement.value = inputElement.value.toUpperCase();
  }
</script>


<?php

include '../footer.php'

  ?>