<?php
session_start();
include '../sidebar.php';

if (isset($_SESSION['EmpUserrole']) && $_SESSION['EmpUserrole'] == "management") {
  // The user has the "management" role
  // echo "User has the management role.";
} else {
  // Redirect to the login page or show an unauthorized message
  header("Location:http://localhost/salon/production/page_403.html");

  
}

  ?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">


    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Profit & Loss Report </h2>
            <ul class="nav navbar-right panel_toolbox">
            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                  <div class="row g-3">

                    <!-- <div class="col-sm">
                      <?php
                      //                $db = dbConn();
//                $sql = "SELECT DISTINCT Model FROM vehicle";
//                $result = $db->query($sql);
                      ?>
                      <select name="payementmethod" class="form-control">
                        <option value="">--Cash Out Type--</option>
                        <option value="stylist">Stylist</option>
                        <option value="management">Management</option>

                      </select>
                    </div> -->
                    <div class="col-sm">
                   
                    <input type="date" class="form-control" name="from" placeholder="Enter From Date" max="<?php echo date('Y-m-d'); ?>" required=true>
                    </div>
                    <div class="col-sm">
                    <input type="date" class="form-control" name="to" placeholder="Enter From Date" max="<?php echo date('Y-m-d'); ?>" required=true>
                  

                    </div>
                    <div class="col-sm">
                      <input type="hidden" name="CustomerId " value=">">
                      <button type="submit" class="btn btn-warning">Search</button>
                    </div>
                  </div>
                </form>
            <!-- <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group ml-1">
                <a href="<?= SYSTEM_PATH ?>reports/sales_report_details.php.php" class="btn btn-sm btn-outline-secondary">More Filter</a>
              </div> -->
              
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          <div class="demo-container" style="height:250px">
            <div class="demo-placeholder">
              <canvas id="myChart1" style="width:95%;height: 90%"></canvas>
            </div>

             <div id="chart_plot_03" ></div>
         </div>
        </div>
        </div>
      </div>
    </div>
<?php 
 $db = dbConn();
 // Check if the form is submitted
 extract($_POST);
 if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $where = 10;
     // Get the start and end dates from the form
     $to_date = $to;
     $from_date = $from;

     // Perform the first query with date range
    $query1 = "SELECT DATE(Addeddate) AS Cashout_day, SUM(Amountcashout) AS total_cashouts FROM tbl_cashout WHERE Addeddate BETWEEN '$from_date' AND '$to_date' GROUP BY DATE(Addeddate) ORDER BY DATE(Addeddate) DESC";
     $result1 =  $db->query($query1);
     // Perform the second query with date range
      $query2 = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleCost) AS total_cost ,SUM(SaleProfit) AS total_profit ,SUM(SaleDiscount) AS total_discounts,SUM(SalesSpecialdiscounts) AS total_special_discount FROM tbl_sales WHERE SaleDate BETWEEN '$from' AND '$to' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
     $result2 =  $db->query($query2);

     // Fetch results and combine based on date
     $combinedData = array();
     $datesArray = array();
     $netTotalArray = array();

     while ($row1 = mysqli_fetch_assoc($result1)) {
         $date = $row1['Cashout_day'];
         $datesArray[] = $date;
         $combinedData[$date] = array('total_cashouts' => $row1['total_cashouts']);
     }

     while ($row2 = mysqli_fetch_assoc($result2)) {
         $date = $row2['sale_day'];
         if (!in_array($date, $datesArray)) {
             $datesArray[] = $date;
         }
       
         if (isset($combinedData[$date])) {
             $combinedData[$date]['total_cost'] = $row2['total_cost'];
             $combinedData[$date]['total_special_discount'] = $row2['total_special_discount'];
             $combinedData[$date]['total_discounts'] = $row2['total_discounts'];
             $combinedData[$date]['total_profit'] = $row2['total_profit'];
             $combinedData[$date]['net_total'] = ($row2['total_cost'] + $combinedData[$date]['total_cashouts'] + $row2['total_discounts'] +  $row2['total_special_discount']);
             $combinedData[$date]['net_totalz'] = ( @$combinedData[$date]['total_cashouts'] + $row2['total_discounts'] +  $row2['total_special_discount']);
             $combinedData[$date]['finalprofitandloss'] = $row2['total_profit'] -(@$combinedData[$date]['total_cashouts'] + $row2['total_discounts'] +  $row2['total_special_discount']);
         } else {
             $combinedData[$date] = array(
                 'total_cost' => $row2['total_cost'],
                 'total_cashouts' => 0,
                 'net_total' => ($row2['total_cost'] + $row2['total_discounts'] +  $row2['total_special_discount']),
                 'total_discounts' => $row2['total_discounts'],
                 'total_special_discount' => $row2['total_special_discount'],
                 'total_profit'  => $row2['total_profit'],
                 'net_totalz' => @$combinedData[$date]['total_cashouts'] + $row2['total_discounts'] +  $row2['total_special_discount'],
                 'finalprofitandloss' => $row2['total_profit'] - ( @$combinedData[$date]['total_cashouts'] + $row2['total_discounts'] +  $row2['total_special_discount'])
             ); 
         }
         $netTotalArray[] = $combinedData[$date]['total_profit'] - $combinedData[$date]['net_totalz'];
     }

     // Sort the array in descending order by date
     krsort($combinedData);
     rsort($datesArray);
 }

?>


<!-- filtering code ends -->

    <div class="row">
      

          
           
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Profit & Loss Table <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <!-- <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
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

                    

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">                        
                           <th class="column-title">Invoice Date </th>
                            <th class="column-title"> Total Sale Cost </th>
                            <th class="column-title"> Total Cashouts </th>
                            <th class="column-title"> Total Disocunts </th>
                            <th class="column-title"> Total Profit </th>
                           
                           
                            
                          </tr>
                        </thead>
                        
<?php 
if (@$where == null) {
 
  $to = date('Y-m-d');
  $from =date('Y-m-d', strtotime('-6 days', strtotime($to)));
  

  // Perform the first query with date range
  $query1 = "SELECT DATE(Addeddate) AS Cashout_day, SUM(Amountcashout) AS total_cashouts FROM tbl_cashout WHERE Addeddate BETWEEN '$from' AND '$to' GROUP BY DATE(Addeddate) ORDER BY DATE(Addeddate) DESC";
  $result1 =  $db->query($query1);
  // Perform the second query with date range
   $query2 = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleCost) AS total_cost ,SUM(SaleProfit) AS total_profit ,SUM(SaleDiscount) AS total_discounts,SUM(SalesSpecialdiscounts) AS total_special_discount FROM tbl_sales WHERE SaleDate BETWEEN '$from' AND '$to' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
  $result2 =  $db->query($query2);

  // Fetch results and combine based on date
  $combinedData = array();
  $datesArray = array();
  $netTotalArray = array();

  while ($row1 = mysqli_fetch_assoc($result1)) {
      $date = $row1['Cashout_day'];
      $datesArray[] = $date;
      $combinedData[$date] = array('total_cashouts' => $row1['total_cashouts']);
  }

  while ($row2 = mysqli_fetch_assoc($result2)) {
      $date = $row2['sale_day'];
      if (!in_array($date, $datesArray)) {
          $datesArray[] = $date;
      }
    
      if (isset($combinedData[$date])) {
          $combinedData[$date]['total_cost'] = $row2['total_cost'];
          $combinedData[$date]['total_special_discount'] = $row2['total_special_discount'];
          $combinedData[$date]['total_discounts'] = $row2['total_discounts'];
          $combinedData[$date]['total_profit'] = $row2['total_profit'];
          $combinedData[$date]['net_total'] = ($row2['total_cost'] + $combinedData[$date]['total_cashouts'] + $row2['total_discounts'] +  $row2['total_special_discount']);
          $combinedData[$date]['net_totalz'] = ( @$combinedData[$date]['total_cashouts'] + $row2['total_discounts'] +  $row2['total_special_discount']);
          $combinedData[$date]['finalprofitandloss'] = $row2['total_profit'] -(@$combinedData[$date]['total_cashouts'] + $row2['total_discounts'] +  $row2['total_special_discount']);
      } else {
          $combinedData[$date] = array(
              'total_cost' => $row2['total_cost'],
              'total_cashouts' => 0,
              'net_total' => ($row2['total_cost'] + $row2['total_discounts'] +  $row2['total_special_discount']),
              'total_discounts' => $row2['total_discounts'],
              'total_special_discount' => $row2['total_special_discount'],
              'total_profit'  => $row2['total_profit'],
              'net_totalz' => @$combinedData[$date]['total_cashouts'] + $row2['total_discounts'] +  $row2['total_special_discount'],
              'finalprofitandloss' => $row2['total_profit'] - ( @$combinedData[$date]['total_cashouts'] + $row2['total_discounts'] +  $row2['total_special_discount'])
          ); 
      }
      $netTotalArray[] = $combinedData[$date]['total_profit'] - $combinedData[$date]['net_totalz'];
  }

  // Sort the array in descending order by date
  krsort($combinedData);
  rsort($datesArray);
       
}


?>
<!-- sales report php sql code end -->
                        <tbody>
                        <?php
                  
                      $i = 1;
                      $totalamount = 0;
                      foreach ($combinedData as $date => $data) :
                        ?>
                          <tr class="even pointer">
                            
                            
                            <td class=" "><?= $date ?> </td>
                            <td class=" "><?php
                            $amount =  $data['total_cost'];
                            

                            
                            echo  number_format ( $amount,2);
                            ?>
                            
                          </td>
                            <td class=" "><?php
                            $amount =  $data['total_cashouts'];

                            
                            echo  number_format ( $amount,2);
                            ?></td>
                            <td class=" "><?php
                            $amount =  @$data['total_discounts'] + @$data['total_special_discount'];

                            
                            echo  number_format ( $amount,2);
                            ?></td>
                            <td class=" "><?php
                            $amount =  $data['total_profit'];

                            
                            echo  number_format ( $amount,2);
                            ?></td>
                            <!-- <td class=" "><?php
                            $amount =  $data['finalprofitandloss'];

                            
                            echo  number_format ( $amount,2);
                            ?></td> -->
                            <?php @$totalamountcost += $data['total_cost'] ?>
                           <?php @$totalamountcashout += $data['total_cashouts'] ?>
                           <?php @$totalamountdiscounts += @$data['total_discounts'] + @$data['total_special_discount'] ?>
                           <?php @$totalamountprofit += $data['total_profit'] ?>
                           <!-- <?php @$totalamountnetprofit += $data['finalprofitandloss'] ?> -->
                          </tr>
                          
                          <?php endforeach; ?>
                         
                        </tbody>
                        <tfoot>
                    <tr>
                      <td colspan=""><strong> Totals</strong>
                      </td>
                      <td>
                        <strong><?= number_format(@$totalamountcost, 2) ?></strong>
                      </td>
                      <td>
                        <strong><?= number_format(@$totalamountcashout, 2) ?></strong>
                      </td>
                      <td>
                        <strong><?= number_format(@$totalamountdiscounts, 2) ?></strong>
                      </td>
                      <td>
                        <strong><?= number_format(@$totalamountprofit, 2) ?></strong>
                      </td>
                      <td>
                        <strong><?= number_format(@$totalamountnetprofit, 2) ?></strong>
                      </td>
                    </tr>
                  </tfoot>
                      </table>
                    </div>
							
						
                  </div>
                </div>
              </div>
            <div class="clearfix"></div>
          
      
    </div>
<!-- /page content -->
<script>
  const ctx = document.getElementById('myChart1');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: [<?= "'" . implode("','", $datesArray) . "'" ?>],
      datasets: [{
        label: 'Profit & Loss',
        data: [<?=  implode(",", $netTotalArray) ?>],
        borderWidth: 3,
        borderColor: 'rgb(75, 192, 192)',
        fill: false,
        tension: 0.1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });


</script>



<?php include '../footer.php' ?>