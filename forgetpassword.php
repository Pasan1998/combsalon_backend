<?php session_start();
ob_start();
include 'config.php';
include 'function.php';
include 'phpmail/mail.php';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="<?= SYSTEM_PATH ?>assets/users/logometa.png">

  <title>CombSalon </title>
 

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

  <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

            
             extract($_POST);

    //creating email variable 
    $Email = cleanInput($Email);

    //createing error messages array
    $messages = array();

    if (empty($Email)) {
        $messages['error_email'] = "The email should not be blank!";
    }


    if (!empty($Email)) {
        $db = dbConn();
//checking whether there have a record where matches with the customer inputs 
        $sql = "SELECT * FROM tbl_emp WHERE EmpEmail='$Email'";
        $result = $db->query($sql);
        $result->num_rows;
        if ($result->num_rows <= 0) {
            //if there is no any matched this error message will show
            $messages['error_invalid'] = "The Email is invalid!";
        } else {
            //if there have match it will assigned $row varibale
            $row = $result->fetch_assoc();
            //assign sessions to customer details
            $_SESSION['Customerid'] = $row['EmpId'];
            
            //these session used to send the mails once the password reset could not access previous method so create session storing customer name email title email 
            $_SESSION['resetcustomeremail'] = $row['EmpEmail'];
            $_SESSION['resetcustomertitle'] = $row['EmpTitle'];
            $_SESSION['resetcustomerfname'] = $row['EmpFName'];
            $_SESSION['resetcustomerlname'] = $row['EmpLName'];
            $_SESSION['EmpId'] = $row['EmpId'];
            
            $titlecustomer = $row['EmpTitle'];
            $firstnamecustomer = $row['EmpFName'];
            $lastnamecustomer = $row['EmpLName'];
            $resetcustomerid = $_SESSION['EmpId'];
            $_SESSION['signedinTime'] = time();
            //left side form value name eka ------ right side database column name eka
            $resetcustomerid = $_SESSION['EmpId'];

            //creating a unique token to send customer
            $customerresettoken = rand(100000, 999999);
            //assign that toker to a session
            $_SESSION['resettoken'] = $customerresettoken;

            //checking whetether there have already passowrd reset column have value if there have value assign that value to session password reset then it is easy to chekc the below logic
            echo $_SESSION['passwordreset'] = $row['passwordreset'];

            $customerpasswordreset = $_SESSION['passwordreset'];

            if ($customerpasswordreset == null) {

//              if empty nm password reset that means first time resetting the password soe have to insert the value of resettoken to users table
                // insert ekk kiwwta customerawa hadankotama me field eka null wela thiyenne eka nisa update ekk damme
                echo $sql = "UPDATE tbl_emp SET passwordreset = '$customerresettoken' WHERE EmpId = '$resetcustomerid' ";
                print_r($sql);
                $db = dbConn();
                $results = $db->query($sql);

                $to = $Email;
                $body = '<!doctype html>
                <html lang="en-US">
                
              <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="<?= SYSTEM_PATH ?>assets/users/logometa.png">

  <title>CombSalon </title>
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
                                          <a href="https://combsalon.lk/" title="logo" target="_blank">
                                            <img width="60" src="https://i.ibb.co/hL4XZp2/android-chrome-192x192.png" title="logo" alt="logo">
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
                                                        <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:"Rubik",sans-serif;">You have
                                                            requested to reset your password</h1>
                                                        <span
                                                            style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                                            We cannot simply send you your old password. A unique link to reset your
                                                            password has been generated for you. To reset your password, click the
                                                            following link and follow the instructions.
                                                        </p>
                                                        <h4>'. $customerresettoken.' </h4>
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
                                            <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong>www.combsalon.lk</strong></p>
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
                $toname = $titlecustomer . $firstnamecustomer . $lastnamecustomer;
                $subject = "Password Reset Token - CombSalon";
                
                $alt = "Customer  Password Reset";
                send_email($to, $toname, $subject, $body, $alt);

                if ($results) {
                    echo "";
                }



                 header("Location:forgetpasswordtwo.php");
                //print_r($sql);
               
            } else {

//      if not empty mean this is not the first password is resetting so have to update the table of user with the new reset token
                echo $sql = "UPDATE tbl_emp SET passwordreset = '$customerresettoken' WHERE EmpId = '$resetcustomerid' ";
                print_r($sql);
                $db = dbConn();
                $results = $db->query($sql);

                $to = $Email;
                $toname = $titlecustomer . $firstnamecustomer . $lastnamecustomer;
                $subject = "Password Reset Token - CombSalon";
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
                                          <a href="https://combsalon.lk/" title="logo" target="_blank">
                                            <img width="60" src="https://combsalon.lk/staff/assets/users/logo.jpg" title="logo" alt="logo">
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
                                                        <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:"Rubik",sans-serif;">You have
                                                            requested to reset your password</h1>
                                                        <span
                                                            style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                                            We cannot simply send you your old password. A unique reset token to  reset your
                                                            password has been generated for you. To reset your password, enter the below unique token number and and follow the instructions.
                                                        </p>
                                                       
                                                        <h4>'. $customerresettoken.' </h4>
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
                                            <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong>www.combsalon.lk</strong></p>
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
                $alt = "Internal User  Password Reset";
                send_email($to, $toname, $subject, $body, $alt);

                if ($results) {
                    echo "";
                }




               header("Location:resetpasswordtwo.php");
                echo 'abc';
            }
        }
    }
}
?>       


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
                  <p> Enter Your Email Address Below</p>
                  <span class="text-danger">
                  <?= @$messages['error_invalid']; ?>
                </span>
                <input type="text" name="Email" class="form-control" value="<?= @$Email ?>" placeholder="Email Address" required="true" />
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
