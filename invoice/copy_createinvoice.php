<?php
session_start();
include '../sidebar.php' ?>
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
				<br />
				<form class="form-horizontal form-label-left">

				<div class="col-md-6 col-sm-6  form-group has-feedback">
				<label class="control-label col-md-3 col-sm-3 ">Customer Name</label>
						<input type="text" class="form-control" id="inputSuccess5" name="customername"
							value="<?= @$customername ?>" placeholder="Customer Name">
						<!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
						<span class="text-danger">
							<?= @$messages['error_customername']; ?>
						</span>
					</div>
					<div class="col-md-6 col-sm-6  form-group has-feedback">
					<label class="control-label col-md-3 col-sm-3 ">Customer Mobile</label>
						<input type="text" class="form-control" id="inputSuccess5" name="customermobile"
							value="<?= @$customermobile ?>" placeholder="Cutomer Mobile Number">
						<!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
						<span class="text-danger">
							<?= @$messages['error_customermobile']; ?>
						</span>
					</div>
					<div class="col-md-6 col-sm-6  form-group has-feedback">
					<label class="control-label col-md-3 col-sm-3 ">Customer  Email</label>
						<input type="password" class="form-control" id="inputSuccess5" name="customeremail"
							value="<?= @$customeremail ?>" placeholder="Customer Email Address">
						<!-- <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span> -->
						<span class="text-danger">
							<?= @$messages['error_customeremail']; ?>
						</span>
					</div>
					<div class="form-group">
						<div class="col-md-9 col-sm-9  offset-md-0">

							<button type="submit" name="action" value="customer" class="btn btn-success">Add Customer Info</button>
						</div>
					</div>

</form>
<div class="ln_solid"></div>
<form class="form-horizontal form-label-left">
					<!-- <div class="form-group row">
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
					</div> -->

					

					
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
								
								<th class="column-title">Service </th>
								<th class="column-title">stylist </th>
								<th class="column-title">amount </th>
								<th class="column-title">Discount </th>
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