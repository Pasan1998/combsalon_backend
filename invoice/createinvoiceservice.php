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
                              $sqlsearch = "select * from tbl_services";
                              $resultsearch = $db->query($sqlsearch);

                              ?>
                              
                              <style>
[type=button], [type=reset], [type=submit], button {
    -webkit-appearance: button;
    color: #495057;
    background-color: white;
    border: none;
    width: 100%;
    text-align: left;
}
</style>
<style>
  .sucess{
    background-color:#169F85;
    padding: 5px 5px;
    width: 40%;
    text-align: center;
    color:whitesmoke;
    font-weight: bold;
  }
  
  </style>
  <style>
    .generate{
       background-color:#169F85;
    padding: 5px 5px;
    width: 40%;
    text-align: center;
    color:whitesmoke;
    font-weight: bold;}
</style>
<style>
    .clearrecords{
       background-color:#dc3545;
    padding: 5px 5px;
    width: 40%;
    text-align: center;
    color:whitesmoke;
    font-weight: bold;}
</style>
                              
                              <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                              <?php


                              $total = 0;

                              extract($_POST);
                              $db = dbConn();
                              if (@$action == 'addservice' && $_SERVER['REQUEST_METHOD'] == 'POST') {

                                $services = cleanInput($services);
                                $stylist = cleanInput($stylist);

                                $messages = array();
                                if (empty($services)) {
                                  $messages['error_services'] = "Service Should be selected!";
                                }
                                if (empty($stylist)) {
                                  $messages['error_stylist'] = "Stylist Should be selected!";
                                }

                                if (empty($messages)) {
                                  //Finding the product by code
                                $sql = "SELECT * FROM tbl_services WHERE ServicesID='$services'";
                                $result = $db->query($sql);
                                $product = $result->fetch_assoc();

                                $sqlemp = "SELECT * FROM tbl_emp WHERE EmpId='$stylist'";
                                $resultemp = $db->query($sqlemp);

                                $emp = $resultemp->fetch_assoc();
                                $stlylistname= ucwords($emp['EmpTitle']. " ".$emp['EmpFName']." ".$emp['EmpLName']);

                                //Incrementing the product qty in cart
                                $_SESSION['products'] [$services] = array('ServiceName' => $product['ServiceName'],'ServicesID' => $product['ServicesID'], 'ServiceCost' => $product['ServiceCost'], 'ServicePrice' => $product['ServicePrice'],'ServiceProfit' => $product['ServiceProfit'],'EmpId' => $emp['EmpId'],'EmpName' =>$stlylistname ,'disccountz' => null, 'specialdiscount' => null,'disccountzcode' => null,'DiscountType'=>null,'ServiceUtilityCost' => $product['UtilityCost'],'ServiceSalaryCost' => $product['SalaryCost']);
                                $product = '';
                                $emp = '';

                                ?>
                                <script>
                                      document.addEventListener('DOMContentLoaded', function () {
                                        Swal.fire({
                                          title: 'Success!',
                                          text: 'Record Added',
                                          icon: 'success',
                                          timer: 800,
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
                                          // window.location.href = '<?= SYSTEM_PATH ?>index.php'; // Redirect to success page
                                        });
                                      });
                                    </script><?php

                                }
                               
                                // $_SESSION['products'] = '';

                              }

                              ?>
                              <?php 
                              extract($_GET);
                              if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'del') {
                                $product = $_SESSION['products'];
                                unset($product[$services]);
                                $_SESSION['products'] = $product;
                                unset ($_SESSION['specialdiscount']);
                                Header('Location:createinvoiceservice.php');
                                
                              }

                              ?>
                              <?php 
                              extract($_GET);
                              if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'clear') {
                                $product = $_SESSION['products'];
                                unset ($_SESSION['products']) ;
                                unset ($_SESSION['specialdiscount']);
                                
                                
                              }

                              ?>

                              <?php 
                              
                              extract($_POST);
                              if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'discounts') {
                                echo $dis = $discounts;
                               echo  $servicesellingprice;

                                if (!empty($dis)) {
                                  $sql = "SELECT * FROM tbl_discountscodes WHERE Discountcodename = '$dis' and DiscountStatus = '1'";
                                  $db = dbConn();
                                  $results = $db->query($sql);
                                  if ($results->num_rows > 0) {
                                    $row = $results->fetch_assoc();
                                    $discountrate= $row['Discountcodepercentage'];
                                    $discountrateid= $row['Discountscodeid'];
                                    $dis=($servicesellingprice / 100) * $discountrate;
                                    $_SESSION['products'][$services]['disccountz'] = $dis;
                                    $_SESSION['products'][$services]['disccountzcode'] = $discountrateid;
                                    $_SESSION['products'][$services]['DiscountType'] = 'DiscountCode';
                                    
                                  }else{
                                    if (intval($dis) && intval($dis) > 0) {
                                    $dis= $dis;
                                    $_SESSION['products'][$services]['disccountz'] = $dis;
                                    $_SESSION['products'][$services]['DiscountType'] = 'CashDiscount';
                                  }else{
                                    echo "Invalid Code";
                                  }
                              }
                                // Check if the array exists in $_SESSION['products'][$services]
                            
                                
                              }}


                              ?>

                              <?php 
                              
                              extract($_POST);
                              if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'special') {
                                echo $specialdis = $specialdiscounts;
                               echo  $netsellingprices;

                                if (!empty($specialdis)) {
                                 echo $sql = "SELECT * FROM tbl_discountscodes WHERE Discountcodename='$specialdis' and DiscountStatus = '1'";
                                  $db = dbConn();
                                  $results = $db->query($sql);
                                  if ($results->num_rows > 0) {
                                    $row = $results->fetch_assoc();
                                    $discountrate= $row['Discountcodepercentage'];
                                    $discountrateid= $row['Discountscodeid'];
                                    $specialdis=($netsellingprices / 100) * $discountrate;
                                    $_SESSION['specialdiscount']= $specialdis;
                                    $_SESSION['specialdiscountcodeid'] = $discountrateid;
                                    $_SESSION['SpecialDiscountType']= 'DiscountCode';
                                    $_SESSION['SpecialDiscountid']= $row['Discountscodeid'];
                                  }else{
                                    if (intval($specialdis) && intval($specialdis) > 0) {
                                    $specialdis= $specialdis;
                                    $_SESSION['specialdiscount']= $specialdis;
                                    $_SESSION['SpecialDiscountType']= 'CashDiscount';
                                    $_SESSION['SpecialDiscountid']= 99999;
                                  }else{
                                    echo "Invalid Code";
                                  }
                              }
                                // Check if the array exists in $_SESSION['products'][$services]
                            
                                
                              }}


                              ?>
                                          
                              <?php 
                              
                              extract($_POST);
                              if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'finish') {
                                
                                date_default_timezone_set('Asia/Colombo');
                                $AddDate= date('Y-m-d');
                                $timestamp = date("Y-m-dHis"); // Get the current timestamp                      
                                $timestamp = str_replace(array('-', ':'), '', $timestamp);               
                              $timestamp=  substr($timestamp, 2);
                              $timestamp = intval($timestamp);
                              $_SESSION['timestamp_invoice'] = $timestamp;
                            //  $type = gettype($timestamp);
                            
                            
                            if ($_SESSION['specialdiscount'] == null || 0){
                                $spcdiz=0;
                            }else{
                                $spcdiz=$_SESSION['specialdiscount'];
                            }
                           
                            $nettotal=$_SESSION['nettotal'];
                            $totaldiscount= $_SESSION['totaldiscount'];
                                $totalqty=0;
                                $totalqty = count($_SESSION['products']);
                            

                          $totalsale = 0;
                          $totalcost = 0;
                          $totalProfit = 0;
                          $totaldisccountz = 0;
                          $totalUtilityCost = 0;
                          $totalSalaryCost = 0 ;
                          foreach ($_SESSION['products'] as $key => $value) {
                            $totalsale += $value['ServicePrice'];
                            $totalcost += $value['ServiceCost'];
                            $totalUtilityCost += $value['ServiceUtilityCost'];
                            $totalSalaryCost += $value['ServiceSalaryCost'];
                            $totalProfit += $value['ServiceProfit'];
                            $totaldisccountz += $value['disccountz'];
                            
                        }

                        $netprofit=  $totalProfit - $_SESSION['netdis'];



                            $Customername = $_SESSION['customer']['CustomerName'];
                            $CustomerMobile = $_SESSION['customer']['CustomerMobile'];
                            $CustomerEmail = $_SESSION['customer']['CustomerEmail'];
                             $paymentmethod = $_SESSION['customer']['paymentmethod'];

                           if ($_SESSION['SpecialDiscountid'] == null || 0){
                                $codeidofspecialdiscount =1;
                            }else{
                              $codeidofspecialdiscount = $_SESSION['SpecialDiscountid'];
                            }

                          
                      
                           if (isset($_SESSION['SpecialDiscountType'])) {
                            $typeofdiscount=$_SESSION['SpecialDiscountType'];
                           }else{
                            $typeofdiscount=0;
                           }

                        $db = dbConn();


                              echo  $sqlsaleinsert="INSERT INTO tbl_sales
                              (SaleInvoiceNumber, SaleDate, SaleAmount, TotalService, CustomerName, SaleDiscount, SaleProfit,
                               SalesSpecialdiscounts,SaleCost,SpecialDiscountType,specialdiscountcodeid,TotalUtitlityCost,TotalSalaryCost,PaymentType,CustomerMobile) 
                                VALUES 
                                (' $timestamp','$AddDate','$totalsale',' $totalqty','$Customername',' $totaldisccountz',' $netprofit',
                                '$spcdiz','$totalcost','$typeofdiscount','$codeidofspecialdiscount','$totalUtilityCost','$totalSalaryCost','$paymentmethod','$CustomerMobile')";

                                $resultssaleinsert = $db->query($sqlsaleinsert);
                                
                                //sending sms to summery to the customer 
                                
                               
                                $sms_total= $totalsale - (@$totaldisccountz +  $spcdiz);
                                number_format($sms_total,2);
                                $MSISDN =  $CustomerMobile;
                                $SRC = 'SendTest';
                                $MESSAGE = "Thank you for choosing CombSalon. Your service invoice number is $timestamp and Total Amount is $sms_total.00";
                                $AUTH = "1748|3OCery8uagXmZNcsd2NU5aBW7eKgFXvv8C2dyjX5 ";  //Replace your Access Token
                                
                                                    $msgdata = array("recipient"=>$MSISDN, "sender_id"=>$SRC, "message"=>$MESSAGE);


                                                        
                                                        $curl = curl_init();
                                                        
                                                        //IF you are running in locally and if you don't have https/SSL. then uncomment bellow two lines
                                                        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                                                        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                                                        
                                                        curl_setopt_array($curl, array(
                                                          CURLOPT_URL => "https://sms.send.lk/api/v3/sms/send",
                                                          CURLOPT_CUSTOMREQUEST => "POST",
                                                          CURLOPT_POSTFIELDS => json_encode($msgdata),
                                                          CURLOPT_HTTPHEADER => array(
                                                          "accept: application/json",
                                                          "authorization: Bearer $AUTH",
                                                          "cache-control: no-cache",
                                                          "content-type: application/x-www-form-urlencoded",
                                                          ),
                                                        ));

                                                        $response = curl_exec($curl);
                                                        $err = curl_error($curl);

                                                        curl_close($curl);

                                                        if ($err) {
                                                          echo "cURL Error #:" . $err;
                                                        } else {
                                                          echo $response;
                                                        }
                                //end of the sending sms summery to the customer
                                
                                
                                $service_id = $db->insert_id;

                                foreach ($_SESSION['products'] as $value) {
                                     $servicediscount = isset($value['disccountz']) ? $value['disccountz'] : 0;
                                 
                            $serviceempid = $value['EmpId'];
                            $serviceprofit = $value['ServiceProfit'];
                            $serviceprice = $value['ServicePrice'];
                            $servicecost = $value['ServiceCost'];
                            $serviceid = $value['ServicesID'];
                            $servicename = $value['ServiceName'];
                           $generaldiscounttype = isset($value['DiscountType']) ? $value['DiscountType'] : 0;
    $generaldiscountcodeid = isset($value['disccountzcode']) ? $value['disccountzcode'] : 0;
                            $UtilityCost = $value['ServiceUtilityCost'];
                            $SalaryCost = $value['ServiceSalaryCost'];


                            $salesrecordnetprofit =  ($serviceprofit - @$servicediscount);
                            $db = dbConn();
                            echo '<br>';
                                echo  $sqlservicerecord="INSERT INTO tbl_sales_services
                                  (Salestableid, ServicesIDSales, TblSalesInnvoceNumber, CustomerName, EmplyoeeID, 
                                  SaleServiceDiscounttype, SaleServiceDiscountcodeid, SaleServiceDiscount, SaleServiceProfit, SaleServiceCost, 
                                  SaleServiceSale, SaleServiceNetProfit,SaleServiceAddedDate,PerSalrayCost,PerUtilityCost) VALUES ('$service_id','$serviceid','$timestamp','$Customername',' $serviceempid ',
                                  '$generaldiscounttype','$generaldiscountcodeid','$servicediscount',' $serviceprofit',' $servicecost','$serviceprice',' $salesrecordnetprofit','$AddDate','$SalaryCost','$UtilityCost')";
                                    $resultssalerecordinsert = $db->query($sqlservicerecord);



                                }
                              
                                header("Location:invoice.php");
                                
                              }


                              ?>
   <script src="<?= SYSTEM_PATH ?>boot/library/bootstrap-5/bootstrap.bundle.min.js"></script> 
        <script src="<?= SYSTEM_PATH ?>boot/library/dselect.js"></script>
                              <!-- page content -->
                              <div class="right_col" role="main">
                                <div class="col-md-12 ">
                                  <div class="x_panel">
                                    <div class="x_title" style="border:none">
                                      <h2>New Invoice <small></small></h2>
                                      <ul class="nav navbar-right panel_toolbox">
                          <li><a href="<?= SYSTEM_PATH ?>invoice/createinvoicecustomer.php" class="collapse-link"><button class=" btn btn-secondary">Customer Info</button></a>
                          </li>

                           <?php 
               if (isset($_SESSION['products'])) {?>
                <li><a href="<?= SYSTEM_PATH ?>invoice/invoice.php" class="collapse-link"><button class=" btn btn-secondary">Invoice</button></a>
          </li><?php
          }else{?>
            <li><a href="<?= SYSTEM_PATH ?>invoice/invoice.php" class="collapse-link"><button disabled class=" btn btn-secondary">Invoice</button></a>
            </li><?php
          }
          ?>
                          
                        </ul>

                                    </div>
                                    <div class="x_content">
                                      <form class="form-horizontal form-label-left" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" >
                                        <div class="form-group row">
                                          <?php
                                          $sqlservices = "SELECT * FROM tbl_services where serviceStatus = '1' ";
                                          $db = dbConn();
                                          $resultservices = $db->query($sqlservices);
                                          ?>
                                         <div class="col-md-6 col-sm-6 ">
                                           
                                            <label class="control-label  ">Select Services</label>
                                            
                                            <select class="form-control" name="services" id="select_box">
                                            <option class="form-control" style="color: #756969; background-color: white; border: none; width: 100%;" value="">-Service Name select-</option>


                                                      <?php 

                                                      foreach ($resultsearch as $rowsearch){
                                                        echo '<option value="'.$rowsearch["ServicesID"].'">'.$rowsearch["ServiceName"].'</option>';
                                                      }
                                                      ?>
                                              <?php
                                              //if ($resultservices->num_rows > 0) {

                                               // while ($rowservices = $resultservices->fetch_assoc()) {
                                                  ?>
                                                 <!-- <option value="<?= $rowservices['ServicesID'] ?>" <?php
                                                   // if (@$services == $rowservices['ServicesID']) {
                                                     // echo "selected";
                                                    //}
                                                    //?>>
                                                   
                                                  </option>

                                                  <?php
                                                //}
                                              //}
                                              ?> -->
                                            </select>
                                            <span class="text-danger">
                              <?= @$messages['error_services']; ?>
                            </span>
                                          </div>
                                          <?php
                                          $sqlstylist = "SELECT * FROM tbl_emp WHERE EmpUserrole = 'stylist' and EmpStatus = '1' ";
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
                                            <span class="text-danger">
                              <?= @$messages['error_stylist']; ?>
                            </span>
                                          </div>
                                        </div>




                                      <div class="form-group">
                                          <div class="col-md-6 col-sm-6  offset-md-9">

                                            <button type="submit" name="action" value="addservice" class="sucess">Add Service</button>
                                          </div>
                                        </div>

                                      </form>
                                    </div>
                                  </div>
                                </div>


                                  <?php 
                                  if (isset($_SESSION['products'])) {?>
                                  
                                  

                                <div class="col-md-12 col-sm-12  ">
                                  <div class="x_panel">
                                    <div class="x_title">
                                      <h2> Treated Services <small></small></h2>
                                      <ul class="nav navbar-right panel_toolbox">
                                      
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

                                              <td class=" "><?=ucfirst( $value['ServiceName']) ?> </td>
                                              <td class=" "><?= $value['EmpName'] ?></td>
                                              <td class=" "><?= number_format($value['ServicePrice'],2) ?></td>
                                            
                                              <?php 
                                              $percentage=$value['disccountz'];
                                              if ( $percentage == null){?>
                                                <td><form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                              <input type="checkbox" class="toggle-checkbox">
                                                <input type="text" class="text-field" name="discounts" style="display: none;">
                                                <input type="hidden" class="text-field" name="services"  value="<?=@$value['ServicesID'] ?>">
                                                <input type="hidden" class="text-field" name="servicesellingprice" value="<?=@$value['ServicePrice'] ?>">
                                              <button type="submit" name="action" value="discounts" class="action-button" style="display: none;">Action</button>
                              </td></form> </td> <?php
                                              }else{ ?>
                                              <td> <?= number_format($percentage,2) ?></td><?php
                                              }
                                              ?>
                                              
                                            
                                              <td><a href="createinvoiceservice.php?action=del&services=<?= $key ?>">Delete</a></td>
                                              </td>

                                              <?php $total +=$value['ServicePrice'];
                                              $totaldiscount += $percentage ?> 
                                            </tr>
                              <?php } ?>
                                          </tbody>
                                        
                                          <tfoot>
                                            <tr>
                                            <td colspan="4" class="text-end">Total amount</td> <td> <?= number_format($total,2) ?></td>
                                            <tr>
                                            <tr>
                                            <td colspan="4" class="text-end">discount amount</td><td><?php 
                                            $_SESSION['totaldiscount']= $totaldiscount;
                                            echo number_format($totaldiscount,2) ?></td>
                                            <tr>
                                            <tr> 
                                              <?php
                                            @$spcdiz=$_SESSION['specialdiscount'];
                                            ?>
                                            <td colspan="4" class="text-end">Special Discount </td>
                                            <?php 
                                            
                                            ?>
                                            
                                              
                                            <?php 
                                                if (isset($_SESSION['specialdiscount'])){?>
                                            
                                            <td> <?= number_format($spcdiz,2) ?> </td>




                                            <?php }else{?>
                                              <td style="display: flex; align-items: center;">
                                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                <?php 
                                                $netz=($total -( $totaldiscount + @$spcdiz));
                                                $_SESSION['nettotalz']=$netz;
                                                ?>
                                                              <input type="checkbox" class="toggle-checkbox">
                                                              <input type="text" class="text-field" name="specialdiscounts" style="display: none;">
                                                              <input type="hidden" class="text-field" name="services" value="<?=@$value['ServicesID'] ?>">
                                                              <input type="hidden" class="text-field" name="netsellingprices" value="<?=@ $_SESSION['nettotalz'] ?>">
                                                              <button type="submit" name="action" value="special" class="action-button " style="display: none; padding: left 5px;">Action</button>
                                                            
                                                          </form>
                                                          </td><?php

                                            }
                                            
                                            ?>
                                        
                                          
                          
                                            <tr>
                                            <td colspan="4" class="text-end">Net  Total amount</td><td> <?php  $net=($total -( $totaldiscount + @$spcdiz));
                                            echo number_format($net,2);
                                            $_SESSION['nettotal']=$net;
                                            $_SESSION['netdis']= @$totaldiscount + @$spcdiz;
                                            ?></td>
                                            <tr>
                                          </tfoot>
                                        </table>
                                               <div class="form-group">
                                          <div class="col-md-9 col-sm-9 ">

                                          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"> 
                                            <button type="submit" name="action" value="finish" class="generate">Generate Bill</button>
                                          </form>
                                          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">  
                                          <button type="submit" name="action" value="clear" class=" clearrecords">Clear Records</button> 
                                        </form>
                                          </div>
                                          

                                        </div>
                                      </div> <?php 
                                      
                                            }?>
                                      



                                    

                                    </div>
                                  </div>
                                </div>
                              </div>
                     <script>

                              var select_box_element = document.querySelector('#select_box');

                              dselect(select_box_element, {
                                  search: true
                              });

                                </script>

                              <script>
                                  $(document).ready(function () {
                                      // Add an event listener to the checkbox
                                      $('.toggle-checkbox').change(function () {
                                          // Toggle the visibility of the associated text field and button
                                          var isChecked = this.checked;
                                          $(this).closest('td').find('.text-field, .action-button').toggle(isChecked);
                                      });
                                  });
                              </script>
                              <!-- /page content -->
                              <?php include '../footer.php';
                              echo' <br>';
                            //   print_r($_SESSION);
                            ob_end_flush();
                              
                              ?>
