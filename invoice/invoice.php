
 <?php 
 ob_start();
session_start();

if ($_SESSION['EmpUserrole'] == 'stylist'){
  include '../sidebar/stylist.php';
}elseif ($_SESSION['EmpUserrole'] == 'management'){
  include '../sidebar/management.php';
}

if (isset($_SESSION['EmpUserrole']) && ($_SESSION['EmpUserrole'] == "management" || $_SESSION['EmpUserrole'] == "stylist")) {
  // The user has the "management" role
  // echo "User has the management role.";
} else {
  // Redirect to the login page or show an unauthorized message
  header("Location:http://localhost/salon/production/page_403.html");

  
}

 ?>
<?php 
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'save') {
  unset($_SESSION['products']);
  unset ($_SESSION['customer']);
  ?>
  <script>
        document.addEventListener('DOMContentLoaded', function () {
          Swal.fire({
            title: 'Success!',
            text: 'Record Added',
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
            window.location.href = '<?= SYSTEM_PATH ?>index.php'; // Redirect to success page
          });
        });
      </script><?php
}
?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <?php 
                  date_default_timezone_set('Asia/Colombo');
                  $timestamp = date("Y-m-dHis"); // Get the current timestamp                      
                  $timestamp = str_replace(array('-', ':'), '', $timestamp);               
                 $timestamp=  substr($timestamp, 2);
                 $timestamp = intval($timestamp);
               $type = gettype($timestamp);
              //  echo "The variable is of type: $type";

                 
                  ?>
                  <div class="x_title">
                    <h2>Invoice No <small><?= $_SESSION['timestamp_invoice']  ?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                    <ul class="nav navbar-right panel_toolbox">
          <li><a href="<?= SYSTEM_PATH ?>invoice/createinvoicecustomer.php" class="collapse-link"><button class=" btn btn-secondary">Customer Info</button></a>
          </li>
          <li><a href="<?= SYSTEM_PATH ?>invoice/createinvoiceservice.php" class="collapse-link"><button class=" btn btn-secondary">Services</button></a>
          </li>
          
          
        </ul>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
<style>
  @media print{
    body * {
      visibility: hidden;
    }
    .printContainer , .printContainer * {
      visibility: visible;
    }
    .printContainer{
      position: relative;
      top: 0 px;
      left: 0 px;
     
    }
    .printContainer{
      border: 20px;
    }
  }
  </style>

                    <section class="content invoice printContainer">
                      <!-- title row -->
                      <div class="row">
                        <div class="  invoice-header">
                          <h1>
                                          CombSalon
                                           Invoice
                                         
                                      </h1>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- info row -->
                      <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                         Customer Details
                          <address>
                            <?php 

                            @$cusname=$_SESSION ['customer']['CustomerName'];
                            @$cusmobile=$_SESSION ['customer']['CustomerMobile'];
                            @$cusemail=$_SESSION ['customer']['CustomerEmail'];
                            ?>
                                          <strong>Name : <?= ucwords( @$cusname ) ?></strong>
                                         
                                          <br><strong>Phone:  <?= @$cusmobile  ?></strong>
                                          <br><strong>Email:<?= @$cusemail  ?></strong>
                                      </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          <!-- To -->
                          <!-- <address>
                                          <strong>John Doe</strong>
                                          <br>795 Freedom Ave, Suite 600
                                          <br>New York, CA 94107
                                          <br>Phone: 1 (804) 123-9876
                                          <br>Email: jon@ironadmin.com 
                                      </address> -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          <b>Invoice: <?= @$_SESSION['timestamp_invoice']  ?></b>
                          <br>

                          <b>Address</b>: 319/1 kaduwela Road Baththaramulla
                          <br>
                          <b>Payment Date:</b> <?php echo $AddDate = date('Y-m-d'); ?>
                          <br>
                          <b>Contact No:</b> 077 8477 460
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <!-- Table row -->
                      <div class="row">
                        <div class="  table">
                        <table class="table table-striped jambo_table bulk_action">
                          

                          <thead>
                            <tr class="headings">

                              <th class="column-title">Service </th>
                              <th class="column-title">stylist </th>
                              <th class="column-title">amount </th>
                              <th class="column-title">Discount </th>
                              
                              
                            </tr>
                          </thead>

                          <tbody>
                          <?php
                      $total=0;
                      $totaldiscount=0;
                      foreach (@$_SESSION['products'] as $key=>$value) {
                      ?>
                            <tr class="even pointer">

                              <td class=" "><?= $value['ServiceName'] ?> </td>
                              <td class=" "><?= $value['EmpName'] ?></td>
                              <td class=" "><?= number_format($value['ServicePrice'],2) ?></td>
                            
                              <?php 
                              $percentage=$value['disccountz'];
                              if ( $percentage == null){?>
                                <td>  <?= number_format($percentage,2) ?> </td> <?php
                              }else{ ?>
                              <td> <?= number_format($percentage,2) ?></td><?php
                              }
                              ?>
                              
                            
                             
                            
                              <?php $total +=$value['ServicePrice'];
                              $totaldiscount += $percentage ?> 
                            </tr>
              <?php } ?>
                          </tbody>
                        
                          <!-- <tfoot>
                            <tr>
                            <td colspan="5" class="text-end">Total amount</td> <td> <?= number_format($total,2) ?></td>
                            <tr>
                            <tr>
                            <td colspan="5" class="text-end">discount amount</td><td><?= number_format($totaldiscount,2) ?></td>
                            <tr>
                            <tr>
                            <td colspan="5" class="text-end">Net  Total amount</td><td> <?php  $net=$total - $totaldiscount ;
                            echo number_format($net,2)?></td>
                            <tr>
                          </tfoot> -->
                        </table>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-md-12">
                        <!-- <p class="lead">Amount Due 2/22/2014</p> -->
                          <div class="table-responsive">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <th style="width:50%">Total:</th>
                                  <td><?= number_format($total,2) ?></td>
                                </tr>
                                <tr>
                                  <th>Discounts</th>
                                  <td><?= number_format($totaldiscount,2) ?></td>
                                </tr>
                                <!-- <tr>
                                  <th>Special Discount</th>
                                  <td class="text-end">$5.80</td>
                                </tr> -->
                                <tr>
                                  <th>Net Total</th>
                                  <td><?php  $net=$total - $totaldiscount ;
                            echo number_format($net,2)?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                          <!-- <p class="lead">Amount Due 2/22/2014</p> -->
                          <!-- <div class="table-responsive">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <th style="width:50%">Total:</th>
                                  <td><?= number_format($total,2) ?></td>
                                </tr>
                                <tr>
                                  <th>Discounts</th>
                                  <td><?= number_format($totaldiscount,2) ?></td>
                                </tr>
                                <tr>
                                  <th>Special Discount</th>
                                  <td>$5.80</td>
                                </tr>
                                <tr>
                                  <th>Net Total</th>
                                  <td><?php  $net=$total - $totaldiscount ;
                            echo number_format($net,2)?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div> -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <!-- this row will not appear when printing -->
                      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
                method="post">

                      <div class="row no-print">
                        <div class=" ">
                          <button class="btn btn-success" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                          <button name="action" value="save" type="submit" class="btn btn-primary pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
                          
                        </div>
                      </div>
                            </form>
                    </section>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
          Copyright © Amith Salon. All Rights Reserved Developed by Pasan Manahara

          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?= SYSTEM_PATH ?>vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
   <script src="<?= SYSTEM_PATH ?>vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="<?= SYSTEM_PATH ?>vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?= SYSTEM_PATH ?>vendors/nprogress/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?= SYSTEM_PATH ?>build/js/custom.min.js"></script>
  </body>
</html>
<?php
ob_end_flush();
?>