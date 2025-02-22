<?php session_start();
ob_start();
include 'config.php';
include 'function.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php


extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  extract($_POST);

  $username = cleanInput($username);
  $password = cleanInput($password);

  $messages = array();

  if (empty($username)) {
    $messages['error_username'] = "The Username should not be blank!";
  }
  if (empty($password)) {
    $messages['error_password'] = "The password should not be blank!";
  }

  if (empty($messages)) {
    $db = dbConn();
    $hashPassword = sha1($password);
    $sql = "SELECT * FROM tbl_emp WHERE EmpUsername='$username' AND EmpPassword='$hashPassword' and EmpStatus = '1' ";
    $result = $db->query($sql);
    $result->num_rows;
    if ($result->num_rows <= 0) {
      $messages['error_invalid'] = "The User Name or Password is invalid!";
    } else {
      date_default_timezone_set('Asia/Colombo');
      $row = $result->fetch_assoc();
      $_SESSION['EmpId'] = $row['EmpId'];
      $customerid = $row['EmpId'];
      $logintime = date("H:i");
      $date = date("Y-m-d");
      $_SESSION['signedinTime'] = time();

      $_SESSION['EmpFName'] = $row['EmpFName'];
      $_SESSION['EmpTitle'] = $row['EmpTitle'];
      $_SESSION['Last_Name'] = $row['EmpLName'];
      $_SESSION['EmpEmail'] = $row['EmpEmail'];
      $_SESSION['EmpNIC'] = $row['EmpNIC'];
      $_SESSION['EmpContact'] = $row['EmpContact'];
      $_SESSION['EmpUserrole'] = $row['EmpUserrole'];
      $_SESSION['EmpImage'] = $row['EmpImage'];


      $sqllogin = "INSERT INTO tbl_login(loginuserid,logintime,date) VALUES ('$customerid','$logintime','$date')";
      $result = $db->query($sqllogin);
      ?>
      <script>
                let timerInterval;
        Swal.fire({
          title: "Auto close alert!",
          html: "I will close in <b></b> milliseconds.",
          timer: 2000,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading();
            const timer = Swal.getPopup().querySelector("b");
            timerInterval = setInterval(() => {
              timer.textContent = `${Swal.getTimerLeft()}`;
            }, 100);
          },
          willClose: () => {
            clearInterval(timerInterval);
          }
        }).then((result) => {
          /* Read more about handling dismissals below */
          if (result.dismiss === Swal.DismissReason.timer) {
            console.log("I was closed by the timer");
          }
        });
      </script>
      <!-- <script>
        document.addEventListener('DOMContentLoaded', function () {
          Swal.fire({
            title: 'Success!',
            text: 'Login Success',
            icon: 'success',
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading();
              const timer = Swal.getPopup().querySelector("b");
              timerInterval = setInterval(() => {
                timer.textContent = `${Swal.getTimerLeft()}`;
              }, 100);
            },
            willClose: () => {
              clearInterval(timerInterval);
            }
            // confirmButtonText: 'OK'
          }).then(() => {
            window.location.href = 'index.php'; // Redirect to success page
          });
        });
      </script> -->

      <?php

      header("Location:index.php");


    }
  }
}
?>


<!doctype html>
<html lang="en">
  <head>
  	<link rel="icon" type="image/x-icon" href="<?= SYSTEM_PATH ?>assets/users/logometa.png">
  	<title>CombSalon Login </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">
	<style>	
		.custom-left-align {
			margin-left: 0 !important; 
			margin-right: auto; 
			}
	</style>
	</head>
	<body class="img js-fullheight" style="background-image: url(images/bg.jpg);">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-start">
				<div class="col-md-4 text-center mb-6">
					<h2 class="heading-section">Welcome to CombSalon</h2>
				</div>
			</div>
			<div class="row justify-content-start">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">Have an account?</h3>
		      	<form ction="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data"
				  method="post"  class="signin-form">
				  <span class="text-danger">
                  <?= @$messages['error_invalid']; ?>
                </span>
		      		<div class="form-group">
		      			<input type="text" class="form-control" placeholder="Username" name="username" value="<?= @$username ?>">
						  <span class="text-danger">
                    <?= @$messages['error_username']; ?>
                  </span>
		      		</div>
	            <div class="form-group">
	              <input id="password-field" type="password" class="form-control" placeholder="Password" name="password" value="<?= @$password ?>">
	              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
				  <span class="text-danger">
                    <?= @$messages['error_password']; ?>
                  </span>
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
	            </div>
	            <div class="form-group d-md-flex ">
	            	<div class="w-50 ">
		            	<label class="checkbox-wrap checkbox-primary">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="forgetpassword.php" style="color: #fff">Forgot Password</a>
								</div>
	            </div>
	          </form>
	          <!-- <p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p> -->
	          <div class="social d-flex text-center">
	          	<!-- <a href="#" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span> Facebook</a>
	          	<a href="#" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span> Twitter</a> -->
	          </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

	</body>
</html>

