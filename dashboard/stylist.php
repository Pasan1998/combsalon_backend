<?php

// if (!isset($_SESSION['empid'])) {
//   // Redirect to the login page
//   header("Location: ../login.php");
   
// }


//check form submit method
if ($_SERVER['REQUEST_METHOD'] == "POST") {


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
    $user_type=$_SESSION['EmpUserrole'];
     $sql = "INSERT INTO tbl_cashout(Cashoutuserid, Amountcashout, Addeddate,Reasonforcashout,cashoutusertype) VALUES ('$AddUser','$cost',' $AddDate','$servicename','$user_type')";
    $result = $db->query($sql);
    ?>
    <script>
      Swal.fire({
        title: 'Success!',
        text: 'Successfully Created User Account.',
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'index.php'; // Redirect to success page
      });
    </script>
    <?php
  }
}
?>
<!-- page content -->
<div class="right_col" role="main">

  <div class="col-md-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Add New Service <small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <!-- <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li> -->
          <!-- <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i
                class="fa fa-wrench"></i></a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#">Settings 1</a>
              <a class="dropdown-item" href="#">Settings 2</a>
            </div>
          </li> -->
          <!-- <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li> -->
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form class="form-horizontal form-label-left" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
          enctype="multipart/form-data" method="post">

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

            <button type="submit" class="btn btn-success">Submit</button>
          </div>

        </form>
      </div>
    </div>
  </div>







  <div class="row">
  </div>
</div>
</div>
<!-- /page content -->
<?php

include 'footer.php'

  ?>