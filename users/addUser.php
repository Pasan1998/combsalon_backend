<?php
session_start();
include '../header.php';
if (isset($_SESSION['EmpUserrole']) && $_SESSION['EmpUserrole'] == "management") {
  // The user has the "management" role
  // echo "User has the management role.";
} else {
  // Redirect to the login page or show an unauthorized message
  header("Location:http://localhost/salon/production/page_403.html");

  
}
 ?>
<?php
//check form submit method
if ($_SERVER['REQUEST_METHOD'] == "POST") {


  //seperate variables and values from the form
  extract($_POST);

  //data clean
  $fname = cleanInput($fname);
  $lname = cleanInput($lname);
  $email = cleanInput($email);
  $password = cleanInput($password);
  $confirmpassword = cleanInput($confirmpassword);

  $username = cleanInput($username);
  $emergencycontact = cleanInput($emergencycontact);
  $contact = cleanInput($contact);
  $address = cleanInput($address);
  $nic = cleanInput($nic);
  $dob = cleanInput($dob);
  $gender = cleanInput($gender);
  $userrole = cleanInput($userrole);
  $title = cleanInput($title);
  $econtactperson = cleanInput($econtactperson);


  $userimage = $_FILES['userimage'];
  //create array variable store validation messages
  $messages = array();

  //validate required fields

  if (empty($fname)) {
    $messages['error_fname'] = "Employee First Name  should not be empty!";
  }

  if (empty($lname)) {
    $messages['error_lname'] = "Employee Last Name  should not be empty!";
  }

  if (empty($email)) {
    $messages['error_email'] = "Employee Email should not be empty!";
  }
  if (empty($password)) {
    $messages['error_password'] = "Employee Password should not be empty!";
  }

  if (empty($confirmpassword)) {
    $messages['error_confirmpassword'] = "Employee Confirm Password should not be empty";
  }
  if (empty($username)) {
    $messages['error_username'] = "Employee Username should not be empty";
  }

  if (empty($emergencycontact)) {
    $messages['error_emergencycontact'] = "Employee Emergency Contact number should not be empty";
  }

  if (empty($contact)) {
    $messages['error_contact'] = "Employee Contact number  should not be empty";
  }

  if (empty($address)) {
    $messages['error_address'] = "Employee Address should not be empty";
  }

  if (empty($nic)) {
    $messages['error_nic'] = "Employee NIC should not be empty";
  }

  if (empty($dob)) {
    $messages['error_dob'] = "Employee Date of Birth should not be empty";
  }

  if (empty($gender)) {
    $messages['error_gender'] = "Employee Gender should not be empty";
  }
  if (empty($userrole)) {
    $messages['error_userrole'] = "Employee Userrole should not be empty";
  }
  if (empty($econtactperson)) {
    $messages['error_econtactperson'] = "Employee Emergency Contact Person Name should not be empty";
  }
  if (empty($title)) {
    $messages['error_title'] = "Employee Title should not be empty";
  }

  if ($_FILES['userimage']['name'] == "") {
    $messages['error_userimage'] = "Employee User Image should not be empty";
  }

  if (!empty($email)) {
    $file_ext = explode(".", $email);
    $file_ext = strtolower(end($file_ext));
    //select allowed file type
    $allowed = array("com", "yahoo", "me");
    //check wether the file type is allowed
    if (in_array($file_ext, $allowed)) {

    } else {
      $messages['file_error_email'] = "Invalid mail type";
    }
  }
  if (!empty($email)) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $messages['error_email'] = "The email is not well formatted..!";
    }
  }

  if ($_FILES['userimage']['name'] != "") {
    $customerImage = $_FILES['userimage'];
    $filename = $customerImage['name'];
    $filetmpname = $customerImage['tmp_name'];
    $filesize = $customerImage['size'];
    $fileerror = $customerImage['error'];
    //take file extension
    $file_ext = explode(".", $filename);
    $file_ext = strtolower(end($file_ext));
    //select allowed file type
    $allowed = array("jpg", "jpeg", "png", "gif");
    //check wether the file type is allowed
    if (in_array($file_ext, $allowed)) {
      if ($fileerror === 0) {
        //file size gives in bytes
        if ($filesize <= 40000000) {
          //giving appropriate file name. Can be duplicate have to validate using function
          $file_name_new = uniqid('', true) . $lname . '.' . $file_ext;
          //directing file destination
          $file_path = "../assets/users/" . $file_name_new;
          //moving binary data into given destination
          if (move_uploaded_file($filetmpname, $file_path)) {
            "The file is uploaded successfully";
          } else {
            $messages['file_error'] = "File is not uploaded";
          }
        } else {
          $messages['file_error'] = "File size is invalid";
        }
      } else {
        $messages['file_error'] = "File has an error";
      }
    } else {
      $messages['file_error'] = "Invalid File type";
    }
  }

  if (!empty($password)) {
    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
      $messages['error_password'] = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.!";
    }
  }

  if ((!empty($password)) && (!empty($confirmpassword))) {

    if ($password != $confirmpassword) {
      $messages['error_password'] = " Passwords are not match";
    }
  }

  if (!empty($username)) {
    $sql = "SELECT * FROM tbl_emp WHERE EmpUsername='$username'";
    $db = dbConn();
    $results = $db->query($sql);
    if ($results->num_rows > 0) {
      $messages['error_username'] = "This Username is already taken !";
    }
  }

  if (empty($messages)) {

    $db = dbConn();
    $cPassword = sha1($password);
    // $AddUser = $_SESSION['UserId'];
    $referencenumber = rand();
    $AddDate = date('y-m-d');
     $sql = "INSERT INTO tbl_emp(EmpFName, EmpLName, EmpDOB, EmpUserrole, EmpNIC, EmpAdress,

     EmpContact, EmpEmergencyContact, EmpUsername, EmpPassword,  Adddate, Adduser, EmpStatus,

     EmpImage, EmpEmail,EmpGender,EmpEmergencyContactPerson,EmpTitle) VALUES 
     ('$fname','$lname','$dob','$userrole','$nic','$address',
     '$contact','$emergencycontact','$username','$cPassword','$AddDate','1','1',
     '$file_name_new','$email', '$gender','$econtactperson','$title')";
    $result = $db->query($sql);
    ?>
    <script> 
    document.addEventListener('DOMContentLoaded', function() {
       Swal.fire({
        title: 'Success!',
        text: 'Successfully Created User Account.',
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'allUsers.php'; // Redirect to success page
      }); });
    </script>
     <?php
  }
}
?> 

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="<?= SYSTEM_PATH ?>index.php" class="site_title"><i class="fa fa-paw"></i> <span>Salon by
                Amitha!</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic img-fluid">
              <img src="<?= SYSTEM_PATH ?>assets/users/<?= $_SESSION['EmpImage'] ?>" alt="..." class="img-circle img-fluid profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2><?php echo ucfirst( $_SESSION['EmpFName'] )?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                <li><a href="<?= SYSTEM_PATH ?>index.php"><i class="fa fa-home"></i> Home </a>

                </li>

                <li><a href="<?= SYSTEM_PATH ?>services/services.php"><i class="fa fa-scissors"></i> Services </a>

</li>
<li><a href="<?= SYSTEM_PATH ?>employers/allemploers.php"><i class="fa fa-user"></i> Stylists </a>

</li>
<li><a href="<?= SYSTEM_PATH ?>reports/salesreport.php"><i class="fa fa-line-chart"></i> Reports </a>

</li>
<li><a href="<?= SYSTEM_PATH ?>users/allUsers.php"><i class="fa fa-users"></i> Users Management </a>

</li>
<li><a href="<?= SYSTEM_PATH ?>discounts/creatediscounts.php"><i class="fa fa-credit-card"></i> Discounts Management </a>

</li>
<li><a href="<?= SYSTEM_PATH ?>expenses/addexpenses.php"><i class="fa fa-money"></i>Expenses Management </a></li>


               
              </ul>
            </div>
           
          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?= SYSTEM_PATH ?>logout.php">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>
          <nav class="nav navbar-nav">
            <ul class=" navbar-right">
              <li class="nav-item dropdown open" style="padding-left: 15px;">
                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                  data-toggle="dropdown" aria-expanded="false">
                  <img class="img-fluid" src="<?= SYSTEM_PATH ?>assets/users/<?= $_SESSION['EmpImage'] ?>" alt=""><?= $_SESSION['EmpTitle']. " ". $_SESSION['EmpFName'] ?>
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                  
                  
                  <a class="dropdown-item" href="<?= SYSTEM_PATH ?>logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                </div>
              </li>

              
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->
<!-- page content -->
<div class="right_col" role="main">
  <div class="row">

    <div class="x_panel">
      <div class="x_title">
        <h2>Add New Employee
          <!-- <small>different form elements</small> -->
        </h2>
        <ul class="nav navbar-right panel_toolbox">
          <!-- <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i
                class="fa fa-wrench"></i></a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#">Settings 1</a>
              <a class="dropdown-item" href="#">Settings 2</a>
            </div>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li> -->
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form class="form-label-left input_mask" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
          enctype="multipart/form-data" method="post">

          <div class="col-md-6 col-sm-6 form-group has-feedback  ">
            <label>Select the title of the User:</label>
            <select class="form-control" name="title" value="<?= @$title ?>">
              <option value="">Select Title</option>
              <option value="Mr" <?php
              if (@$title == "Mr") {
                echo "selected";
              }
              ?>>Mr</option>
              <option value="Mrs" <?php
              if (@$title == "Mrs") {
                echo "selected";
              }
              ?>>Mrs</option>
              <option value="Miss" <?php
              if (@$title == "Miss") {
                echo "selected";
              }
              ?>>Miss</option>


            </select>
            <span class="text-danger">
              <?= @$messages['error_title']; ?>
            </span>
          </div>

          <div class="col-md-6 col-sm-6 form-group has-feedback">
          <label> Select the Gender</label>
            <select class="form-control" name="gender" value="<?= @$gender ?>">
              <option value="">Select Gender</option>
              <option value="male" <?php
              if (@$gender == "male") {
                echo "selected";
              }
              ?>>Male</option>
              <option value="female" <?php
              if (@$gender == "female") {
                echo "selected";
              }
              ?>>Female</option>

            </select>
            <span class="text-danger">
              <?= @$messages['error_gender']; ?>
            </span>
          </div>

          <div class="col-md-6 col-sm-6 form-group has-feedback">
          <label>Enter First Name :</label>
            <input type="text" class="form-control has-feedback-left" name="fname" value="<?= @$fname ?>"
              id="inputSuccess2" placeholder="First Name">
            <!-- <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> -->
            <span class="text-danger">
              <?= @$messages['error_fname']; ?>
            </span>
          </div>

          <div class="col-md-6 col-sm-6  form-group has-feedback">
          <label> Enter Last Name :</label>
            <input type="text" class="form-control" id="inputSuccess3" name="lname" value="<?= @$lname ?>"
              placeholder="Last Name">
            <!-- <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span> -->
            <span class="text-danger">
              <?= @$messages['error_lname']; ?>
            </span>
          </div>

          <div class="col-md-6 col-sm-6  form-group has-feedback">
          <label> Enter Date of birth :</label>
            <input class="date-picker form-control" placeholder="DD-MM-YYYY" name="dob" type="text"
              onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'"
              onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
            <script>
              function timeFunctionLong(input) {
                setTimeout(function () {
                  input.type = 'text';
                }, 60000);
              }
            </script>
            <span class="text-danger">
              <?= @$messages['error_dob']; ?>
            </span>

          </div>

          <div class="col-md-6 col-sm-6  form-group has-feedback">
          <label> Enter NIC number :</label>
            <input type="text" class="form-control" id="inputSuccess5" name="nic" value="<?= @$nic ?>"
              placeholder="NIC">
            <!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
            <span class="text-danger">
              <?= @$messages['error_nic']; ?>
            </span>
          </div>


          <div class="col-md-6 col-sm-6  form-group has-feedback">
          <label> Address</label>
            <input type="text" class="form-control" id="inputSuccess5" name="address" value="<?= @$address ?>"
              placeholder="Address">
            <!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
            <span class="text-danger">
              <?= @$messages['error_address']; ?>
            </span>
          </div>



          <div class="col-md-6 col-sm-6  form-group has-feedback">
          <label> Enter Email Address :</label>
            <input type="text" class="form-control" id="inputSuccess5" name="email" value="<?= @$email ?>"
              placeholder="Email">
            <!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
            <span class="text-danger">
              <?= @$messages['error_email']; ?>
            </span>
          </div>



          <div class="col-md-6 col-sm-6  form-group has-feedback">
          <label> Enter Mobile Nummber :</label>
            <input type="tel" class="form-control" id="inputSuccess5" name="contact" value="<?= @$contact ?>"
              placeholder="Contact">
            <!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
            <span class="text-danger">
              <?= @$messages['error_contact']; ?>
            </span>
          </div>

          <div class="col-md-6 col-sm-6  form-group has-feedback">
          <label> Enter Emergency Contact Person Name :</label>
            <input type="text" class="form-control" id="inputSuccess5" name="econtactperson"
              value="<?= @$econtactperson ?>" placeholder="Emergency Contact Person">
            <!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
            <span class="text-danger">
              <?= @$messages['error_econtactperson']; ?>
            </span>

          </div>

          <div class="col-md-6 col-sm-6  form-group has-feedback">
          <label> Enter Emergency Contact Person Mobile :</label>
            <input type="number" class="form-control" id="inputSuccess5" name="emergencycontact"
              value="<?= @$emergencycontact ?>" placeholder="Emergency Contact">
            <!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
            <span class="text-danger">
              <?= @$messages['error_emergencycontact']; ?>
            </span>

          </div>

          


          <div class="col-md-6 col-sm-6  form-group has-feedback">
          <label> Enter User Name :</label>
            <input type="text" class="form-control" id="inputSuccess5" name="username" value="<?= @$username ?>"
              placeholder="Username">
            <!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
            <span class="text-danger">
              <?= @$messages['error_username']; ?>
            </span>

          </div>


          <div class="col-md-6 col-sm-6  form-group has-feedback">
          <label> Upload the User Image :</label>
            <input type="file" class="form-control" id="inputSuccess5" name="userimage" value="<?= @$userimage ?>"
              placeholder="User Image">
            <!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
            <span class="text-danger">
              <?= @$messages['error_userimage']; ?>
            </span>
            <span class="text-danger">
              <?= @$messages['file_error']; ?>
            </span>
          </div>


          <div class="col-md-6 col-sm-6  form-group has-feedback">
          <label> Enter Password: (8+ characters: 1 Uppercase, 1 Lowercase, 1 Number, 1 Special Character.) : </label>
            <input type="password" class="form-control" id="inputSuccess5" name="password" value="<?= @$password ?>"
              placeholder="Password">
            <!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
            <span class="text-danger">
              <?= @$messages['error_password']; ?>
            </span>
          </div>


          <div class="col-md-6 col-sm-6  form-group has-feedback">
          <label> Enter Password :(8+ characters: 1 Uppercase, 1 Lowercase, 1 Number, 1 Special Character. ):</label>
            <input type="password" class="form-control" id="inputSuccess5" name="confirmpassword"
              value="<?= @$confirmpassword ?>" placeholder="Confirm Password">
            <!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
            <span class="text-danger">
              <?= @$messages['error_confirmpassword']; ?>
            </span>
          </div>


          

          <div class="col-md-6 col-sm-6 ">
          <label> Select the User Role</label>
            <select class="form-control" name="userrole" value="<?= @$userrole ?>">
              <option value="">Select Userrole</option>
              <option value="stylist" <?php
              if (@$userrole == "stylist") {
                echo "selected";
              }
              ?>>Stylist</option>
              <option value="management" <?php
              if (@$userrole == "management") {
                echo "selected";
              }
              ?>>Management
              </option>

            </select>


            
            <span class="text-danger">
              <?= @$messages['error_userrole']; ?>
            </span>
          </div>

          <div class="col-md-12 col-sm-12  offset-md-11">

            <button type="submit" class="btn btn-success">Submit</button>
          </div>


        </form>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<?php include '../footer.php' ?>















