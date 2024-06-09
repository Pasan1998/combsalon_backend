<?php
session_start();
include 'sidebar.php' ?>

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
          $file_path = "assets/users/" . $file_name_new;
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
    echo $sql = "INSERT INTO tbl_emp(EmpFName, EmpLName, EmpDOB, EmpUserrole, EmpNIC, EmpAdress,

     EmpContact, EmpEmergencyContact, EmpUsername, EmpPassword,  Adddate, Adduser, EmpStatus,

     EmpImage, EmpEmail,EmpGender,EmpEmergencyContactPerson,EmpTitle) VALUES 
     ('$fname','$lname','$dob','$userrole','$nic','$address',
     '$contact','$emergencycontact','$username','$cPassword','$AddDate','1','1',
     '$file_name_new','$email', '$gender','$econtactperson','$title')";
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
				<h2>New Invoice <small></small></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
							aria-expanded="false"><i class="fa fa-wrench"></i></a>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="#">Settings 1</a>
							<a class="dropdown-item" href="#">Settings 2</a>
						</div>
					</li>
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
<form class="form-horizontal form-label-left">
					<div class="form-group row">
						<?php
						$sqlservices = "SELECT * FROM tbl_services ";
						$db = dbConn();
						$resultservices = $db->query($sqlservices);
						?>
						<div class="col-md-6 col-sm-6 ">
							<label class="control-label col-md-3 col-sm-3 ">Select Services</label>
							<select class="form-control" name="services">
								<option value="">-Service Name-</option>
								<?php
								if ($resultservices->num_rows > 0) {

									while ($rowservices = $resultservices->fetch_assoc()) {
										?>
										<option value="<?= $rowservices['ServicesID'] ?>" <?php
										  if (@$services == $rowservices['ServicesID']) {
											  echo "selected";
										  }
										  ?>>
											<?= ucfirst($rowservices['ServiceName']) ?>
										</option>

										<?php
									}
								}
								?>
							</select>
						</div>
						<?php
						$sqlstylist = "SELECT * FROM tbl_emp WHERE EmpUserrole = 'stylist' ";
						$db = dbConn();
						$resultstylist = $db->query($sqlstylist);
						?>
						<div class="col-md-6 col-sm-6 ">
							<label class="control-label col-md-3 col-sm-3 ">Select Stylist</label>
							<select class="form-control" name="stylist">
								<option value="">-Stylist Name-</option>
								<?php
								if ($resultstylist->num_rows > 0) {

									while ($rowstylist = $resultstylist->fetch_assoc()) {
										?>
										<option value="<?= $rowstylist['EmpId'] ?>" <?php
										  if (@$stylist == $rowstylist['EmpId']) {
											  echo "selected";
										  }
										  ?>>
											<?= ucfirst($rowstylist['EmpFName']) . " " . ucfirst($rowstylist['EmpLName']) ?>
										</option>

										<?php
									}
								}
								?>
							</select>
						</div>
					</div>

					

					
					<div class="form-group">
						<div class="col-md-9 col-sm-9  offset-md-10">

							<button type="submit" name="" class="btn btn-success">Add Service</button>
						</div>
					</div>
					
				</form>
			</div>
		</div>
	</div>

	<div class="col-md-12 col-sm-12  ">
		<div class="x_panel">
			<div class="x_title">
				<h2> Treated Services <small></small></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
							aria-expanded="false"><i class="fa fa-wrench"></i></a>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="#">Settings 1</a>
							<a class="dropdown-item" href="#">Settings 2</a>
						</div>
					</li>
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>

			<div class="x_content">



				<div class="table-responsive">
					<table class="table table-striped jambo_table bulk_action">
						<thead>
							<tr class="headings">
								<th>
									<input type="checkbox" id="check-all" class="flat">
								</th>
								<th class="column-title">Invoice </th>
								<th class="column-title">Invoice Date </th>
								<th class="column-title">Order </th>
								<th class="column-title">Bill to Name </th>
								<th class="column-title">Status </th>
								<th class="column-title">Amount </th>
								<th class="column-title no-link last"><span class="nobr">Action</span>
								</th>
								<th class="bulk-actions" colspan="7">
									<a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
											class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
								</th>
							</tr>
						</thead>

						<tbody>
							<tr class="even pointer">
								<td class="a-center ">
									<input type="checkbox" class="flat" name="table_records">
								</td>
								<td class=" ">121000040</td>
								<td class=" ">May 23, 2014 11:47:56 PM </td>
								<td class=" ">121000210 <i class="success fa fa-long-arrow-up"></i></td>
								<td class=" ">John Blank L</td>
								<td class=" ">Paid</td>
								<td class="a-right a-right ">$7.45</td>
								<td class=" last"><a href="#">View</a>
								</td>
							</tr>

						</tbody>
					</table>
				</div>


			</div>
		</div>
	</div>




</div>
<?php include 'footer.php' ?>