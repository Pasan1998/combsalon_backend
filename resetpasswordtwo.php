<?php session_start();
ob_start();
include 'config.php';
include 'function.php';
include 'phpmail/mail.php';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                extract($_POST);
                //creating email variable 
                $token = cleanInput($token);
                $newpassword = cleanInput($newpassword);
                $conpassword = cleanInput($conpassword);

                $resetcustomerid = $_SESSION['EmpId'];

                $Email = $_SESSION['resetcustomeremail'];
                $titlecustomer = $_SESSION['resetcustomertitle'];
                $firstnamecustomer = $_SESSION['resetcustomerfname'];
                $lastnamecustomer = $_SESSION['resetcustomerlname'];

                $messages = array();

                if (empty($token)) {
                    $messages['error_token'] = "The token should not be blank!";
                }
                if (empty($newpassword)) {
                    $messages['error_newpassword'] = "The new password should not be blank!";
                }
                if (empty($conpassword)) {
                    $messages['error_conpassword'] = "The new confirm password should not be blank!";
                }
                //advanced password

                if (!empty($newpassword)) {
                    // Validate password strength
                    if (strlen($newpassword) < 2) {
                        $messages['error_newpassword'] = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.!";
                    }
                }

                if ((!empty($newpassword)) && (!empty($conpassword))) {

                    if ($newpassword != $conpassword) {
                        $messages['error_newpassword'] = " Passwords are not match";
                    }
                }


                if (!empty($token)) {

//        print_r($resetcustomerid);
                    echo $sql = "SELECT * FROM tbl_emp WHERE passwordreset='$token' AND EmpId=$resetcustomerid";
                    $db = dbConn();
                    $results = $db->query($sql);
                    if ($results->num_rows > 0) {
                        
                    } else {
                        $messages['error_token'] = "This Entered token is invalid";
                    }
                }


                if (empty($messages)) {
                    $db = dbConn();
                    $newpassword = sha1($newpassword);
                    echo $sql2 = "UPDATE tbl_emp SET EmpPassword = '$newpassword' WHERE EmpId= '$resetcustomerid'";
                    $result2 = $db->query($sql2);

                    $to = $Email;
                    $toname = $titlecustomer . $firstnamecustomer . $lastnamecustomer;
                    $attachment = 'assets/img/signup/jpg';
                    $subject = "Password Reset Success - CombSalon";
                    $body = '<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Reset Password Email Template</title>
    <meta name="description" content="Reset Password Email">
    <style type="text/css">
        a:hover {text-decoration: underline !important;}
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
    <!--100% body table-->
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
        style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: "Open Sans", sans-serif;">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                          <a href="https://rakeshmandal.com" title="logo" target="_blank">
                            <img width="60" src=' . $attachment . ' title="logo" alt="logo">
                          </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">
                                        <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:"Rubik",sans-serif;">Sucessfully Reset the password !!</h1>
                                        <span
                                            style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                            Your password have been changed.
                                        </p>
                                        <h4> </h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong> CombSalon</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--/100% body table-->
</body>

</html>';
                    $alt = "Customer  Password Reset Success !";
                    send_email($to, $toname, $subject, $body, $alt);

                    if ($results) {
                        echo "";
                    }



                    session_destroy();
                    header("Location:login.php");
                }
            }
            ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>

    <!-- Bootstrap -->
    <link href="<?= SYSTEM_PATH ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= SYSTEM_PATH ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= SYSTEM_PATH ?>vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?= SYSTEM_PATH ?>vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?= SYSTEM_PATH ?>build/css/custom.min.css" rel="stylesheet">
  </head>
      


  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
                method="post">
              <h1>Password Reset Form</h1>
              <div>
                  <p> Enter Your New Password Below</p>
                  <span class="text-danger">
                  <?= @$messages['error_newpassword']; ?>
                </span>
                <input type="password" name="newpassword" class="form-control" value="<?= @$newpassword ?>" placeholder="Enter New Password" required="true" />
              </div>

              <div>
                  <p> Enter Your Confirm Password Below</p>
                  <span class="text-danger">
                  <?= @$messages['error_conpassword']; ?>
                </span>
                <input type="password" name="conpassword" class="form-control" value="<?= @$conpassword ?>" placeholder="Enter Confirm Password" required="true" />
              </div>

              <div>
                  <p> Enter Your Token Below</p>
                  <span class="text-danger">
                  <?= @$messages['error_token']; ?>
                </span>
                <input type="text" name="token" class="form-control" value="<?= @$token ?>" placeholder="Enter Token" required="true" />
              </div>
             
             <div>
                 
               <button class="btn btn-info submit" type="submit" >Search</button>
             
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <!--<p class="change_link">New to site?-->
                <!--  <a href="#signup" class="to_register"> Create Account </a>-->
                <!--</p>-->

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1>Combsalon!</h1>
                  <p>©2024 All Rights Reserved</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        
      </div>
    </div>
  </body>
</html>
