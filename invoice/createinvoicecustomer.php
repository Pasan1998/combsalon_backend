<?php
ob_start();
session_start();
include '../sidebar.php';

if (isset($_SESSION['EmpUserrole']) && ($_SESSION['EmpUserrole'] == "management" || $_SESSION['EmpUserrole'] == "stylist")) {
  // The user has the "management" role
  // echo "User has the management role.";
} else {
  // Redirect to the login page or show an unauthorized message
  header("Location:http://localhost/salon/production/page_403.html");


}
$db = dbConn();
$sqlsearch = "select * from tbl_sales";
$resultsearch = $db->query($sqlsearch);
?>

<?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && $action == 'customer') {


  @$customername = cleanInput($customername);
  @$customermobile = cleanInput($customermobile);
  @$customeremail = cleanInput($customeremail);
  @$paymentmethod = cleanInput($paymentmethod);

  $messages = array();
  if (empty($customername)) {
    $messages['error_customername'] = "Customer Name  should not be empty!";
  }

  if (empty($customermobile)) {
    $messages['error_customermobile'] = "Customer Mobile  should not be empty!";
  }
  if (!empty($customermobile) && ($customermobile < 0)) {
    $messages['error_customermobile'] = "Customer Mobile  should not be minus value !";
  }

  if (empty($paymentmethod)) {
    $messages['error_paymentmethod'] = "Payement Method Should be selected!";
  }

  print_r($messages);

  if (empty($messages)) {
    $_SESSION['customer'] = array('CustomerName' => $customername, 'CustomerMobile' => $customermobile, 'CustomerEmail' => $customeremail, 'paymentmethod' => $paymentmethod);
    header('Location:createinvoiceservice.php');

  }




}




?>
<style>
  /* Style to hide the up and down arrows */
  input[type="number"]::-webkit-inner-spin-button,
  input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  input[type="number"] {
    -moz-appearance: textfield;
  }
</style>
<script src="<?= SYSTEM_PATH ?>boot/library/bootstrap-5/bootstrap.bundle.min.js"></script>
<script src="<?= SYSTEM_PATH ?>boot/library/dselect.js"></script>
<!-- page content -->
<div class="right_col" role="main">
  <div class="col-md-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>New Invoice <small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <?php
          if (isset($_SESSION['products'])) { ?>

            <li><a href="<?= SYSTEM_PATH ?>invoice/createinvoiceservice.php" class="collapse-link"><button
                  class=" btn btn-secondary">Services</button></a>
            </li><?php
          } else { ?>
            <li><a href="<?= SYSTEM_PATH ?>invoice/createinvoiceservice.php" class="collapse-link"><button disabled
                  class=" btn btn-secondary">Services</button></a>
            </li><?php

          }
          ?>

          <?php
          if (isset($_SESSION['products'])) { ?>
            <li><a href="<?= SYSTEM_PATH ?>invoice/invoice.php" class="collapse-link"><button
                  class=" btn btn-secondary">Invoice</button></a>
            </li><?php
          } else { ?>
            <li><a href="<?= SYSTEM_PATH ?>invoice/invoice.php" class="collapse-link"><button disabled
                  class=" btn btn-secondary">Invoice</button></a>
            </li><?php
          }
          ?>



        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <?php
        @$customername = $_SESSION['customer']['CustomerName'];
        @$customermobile = $_SESSION['customer']['CustomerMobile'];
        @$customeremail = $_SESSION['customer']['CustomerEmail'];
        @$paymentmethod = $_SESSION['customer']['paymentmethod'];
        ?>
        <form class="form-horizontal form-label-left" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
          method="POST">

          <div class="col-md-6 col-sm-6  form-group has-feedback">
            <label class="control-label col-md-3 col-sm-3 ">Customer Name</label>
            <input type="text" class="form-control" id="" name="customername"
              value="<?= @$customername ?>" placeholder="Customer Name">
            <!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
            <span class="text-danger">
              <?= @$messages['error_customername']; ?>
            </span>
          </div>

          <!--  -->
          <div class="col-md-6 col-sm-6 form-group has-feedback">
            <label class="control-label col-md-3 col-sm-3">Customer Mobile</label>
             <input type="text" class="form-control numeric-input" name="customermobile"
                value="<?= @$customermobile ?>" placeholder="Customer Mobile Number">
              <span class="text-danger">
                <?= @$messages['error_customermobile']; ?>
              </span>
            </div>

          <!--  -->

          <!-- <div class="col-md-6 col-sm-6 ">

            <label class="control-label  ">Customer mobile</label>

            <select class="form-control" name="customermobile" id="select_box">
            <input type="text" class="form-control" id="limitedinput" name="customermobile"
            value="<?= @$customeremail ?>" placeholder="Customer Mobile Number">
            <span class="text-danger">
              <?= @$messages['error_customermobile']; ?>
            </span>
          </div> -->
          <div class="col-md-6 col-sm-6  form-group has-feedback">
            <label class="control-label col-md-6 col-sm-6 ">Customer Email</label>
            <input type="email" class="form-control" id="limitedinput" name="customeremail"
              value="<?= @$customeremail ?>" placeholder="Customer Email Address">
            <!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
            <span class="text-danger">
              <?= @$messages['error_customeremail']; ?>
            </span>
          </div>

          <div class="col-md-6 col-sm-6 ">
            <label class="control-label col-md-6 col-sm-6 ">Select Payment method</label>
            <select class="form-control" name="paymentmethod">
              <option value="">-Payment Method-</option>

              <option value="1" <?php if (@$paymentmethod == "1") {
                echo "selected";
              } ?>>Cash Payment</option>
              <option value="2" <?php if (@$paymentmethod == "2") {
                echo "selected";
              } ?>>Card Payment</option>


            </select>
            <span class="text-danger">
              <?= @$messages['error_paymentmethod']; ?>
            </span>
          </div>

          <div class="form-group">
            <div class="col-md-9 col-sm-9  offset-md-0">

              <button type="submit" name="action" value="customer" class="btn btn-success">Add Customer Info</button>
            </div>
          </div>

        </form>


      </div>
    </div>
  </div>


</div>
<script>
  document.querySelectorAll('.numeric-input').forEach(function(input) {
    input.addEventListener('input', function(e) {
      const maxLength = 10; // Set the desired maximum length
      this.value = this.value.replace(/\D/g, ''); // Allow only numeric characters
      if (this.value.length > maxLength) {
        this.value = this.value.slice(0, maxLength); // Trim the value to the maximum length
      }
    });
  });
</script>

<?php include '../footer.php';

print_r($_SESSION);

ob_end_flush(); ?>