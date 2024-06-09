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
        //         let timerInterval;
        // Swal.fire({
        //   title: "Auto close alert!",
        //   html: "I will close in <b></b> milliseconds.",
        //   timer: 2000,
        //   timerProgressBar: true,
        //   didOpen: () => {
        //     Swal.showLoading();
        //     const timer = Swal.getPopup().querySelector("b");
        //     timerInterval = setInterval(() => {
        //       timer.textContent = `${Swal.getTimerLeft()}`;
        //     }, 100);
        //   },
        //   willClose: () => {
        //     clearInterval(timerInterval);
        //   }
        // }).then((result) => {
        //   /* Read more about handling dismissals below */
        //   if (result.dismiss === Swal.DismissReason.timer) {
        //     console.log("I was closed by the timer");
        //   }
        // });
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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/x-icon" href="<?= SYSTEM_PATH ?>assets/users/logometa.png">

<title>CombSalon </title>

  <link href="<?= SYSTEM_PATH ?>assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= SYSTEM_PATH ?>assets/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?= SYSTEM_PATH ?>assets/css/style.css" rel="stylesheet">

  
</head>

<body>
  <section class="form-02-main">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="_lk_de">
            <div class="form-03-main">
              <div class="logo">
                <img src="assets/images/user.png">
              </div>
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data"
                method="post">
                <span class="text-danger">
                  <?= @$messages['error_invalid']; ?>
                </span>
                <div class="form-group">
                  <input type="text" name="username" value="<?= @$username ?>" class="form-control _ge_de_ol"
                    type="text" placeholder="Enter Username">
                  <span class="text-danger">
                    <?= @$messages['error_username']; ?>
                  </span>
                </div>

                <div class="form-group">
                  <input type="password" name="password" value="<?= @$password ?>" class="form-control _ge_de_ol"
                    type="text" placeholder="Enter Password">
                  <span class="text-danger">
                    <?= @$messages['error_password']; ?>
                  </span>
                </div>

                <div class="checkbox form-group">

                  <a href="forgetpassword.php">Forgot Password</a>
                </div>

                <div class="form-group">
                  <button class="_btn_04" type="submit">
                    Login
                  </button>
                </div>

              </form>

              <div class="form-group pt-0">
                <div class="_social_04">
                  <ol>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>

<?php
ob_end_flush();
?>