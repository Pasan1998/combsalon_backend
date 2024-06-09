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
            <h2>Cash Out  Report</h2>
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
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $where = 10;
             $to_date = $to;
             $from_date = $from;
             
             $db = dbConn();
   // Perform the first query with date range
   $query_cash_out = "SELECT DATE(Addeddate) AS Cashout_day, SUM(Amountcashout) AS total_cashouts FROM tbl_cashout WHERE Addeddate BETWEEN '$from_date' AND '$to_date' GROUP BY DATE(Addeddate) ORDER BY DATE(Addeddate) DESC";
   $result_cash_out =  $db->query($query_cash_out);
   
   // Perform the second query with date range
    $query_cash_out_2 = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleCost) AS total_cost FROM tbl_sales WHERE SaleDate BETWEEN '$from_date' AND '$to_date' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
    $result_cash_out_2 =  $db->query($query_cash_out_2);

   // Fetch results and combine based on date
   $combinedData_cash_out = array();
   $datesArray_cash_out = array();
   $netTotalArray_cash_out = array();

   while ($row1 = mysqli_fetch_assoc($result_cash_out)) {
     $date = $row1['Cashout_day'];
 
     // Add the date to $datesArray_cash_out if not already present
     if (!in_array($date, $datesArray_cash_out)) {
         $datesArray_cash_out[] = $date;
     }
 
     // Populate $combinedData_cash_out with cashout data
     $combinedData_cash_out[$date] = array(
         'total_cashouts' => $row1['total_cashouts']
     );
 
     // Populate $netTotalArray_cash_out for this date
     $netTotalArray_cash_out[$date] = $combinedData_cash_out[$date]['total_cashouts'];
 }
  
 

   // Sort the array in descending order by date
    "<br>";
   krsort( $combinedData_cash_out);
   rsort($datesArray_cash_out);
   
  
    "'" . implode("','", $datesArray_cash_out) . "'";
   //print_r($datesArray);
    "<br>";
     implode(",", $netTotalArray_cash_out);
              }
             ?>

<!-- filtering code ends -->

    <div class="row">
      

          
           
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cash Out Table <small></small></h2>
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
                            <th class="column-title"> Sum Of Sale Cost </th>
                            
                          </tr>
                        </thead>
                        
<?php 
if (@$where == null) {
 
  $to = date('Y-m-d');
  $from =date('Y-m-d', strtotime('-6 days', strtotime($to)));
  
  $db = dbConn();
   // Perform the first query with date range
   $query_cash_out = "SELECT DATE(Addeddate) AS Cashout_day, SUM(Amountcashout) AS total_cashouts FROM tbl_cashout WHERE Addeddate BETWEEN '$from' AND '$to' GROUP BY DATE(Addeddate) ORDER BY DATE(Addeddate) DESC";
   $result_cash_out =  $db->query($query_cash_out);
   
   // Perform the second query with date range
    $query_cash_out_2 = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleCost) AS total_cost FROM tbl_sales WHERE SaleDate BETWEEN '$from' AND '$to' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
    $result_cash_out_2 =  $db->query($query_cash_out_2);

   // Fetch results and combine based on date
   $combinedData_cash_out = array();
   $datesArray_cash_out = array();
   $netTotalArray_cash_out = array();

   while ($row1 = mysqli_fetch_assoc($result_cash_out)) {
     $date = $row1['Cashout_day'];
 
     // Add the date to $datesArray_cash_out if not already present
     if (!in_array($date, $datesArray_cash_out)) {
         $datesArray_cash_out[] = $date;
     }
 
     // Populate $combinedData_cash_out with cashout data
     $combinedData_cash_out[$date] = array(
         'total_cashouts' => $row1['total_cashouts']
     );
 
     // Populate $netTotalArray_cash_out for this date
     $netTotalArray_cash_out[$date] = $combinedData_cash_out[$date]['total_cashouts'];
 }
  
 

   // Sort the array in descending order by date
    "<br>";
   krsort( $combinedData_cash_out);
   rsort($datesArray_cash_out);
   rsort($datesArray_cash_out);
  
    "'" . implode("','", $datesArray_cash_out) . "'";
   //print_r($datesArray);
    "<br>";
     implode(",", $netTotalArray_cash_out);
       
}


?>
<!-- sales report php sql code end -->
                        <tbody>
                        <?php
                  
                      $i = 1;
                      $totalamount = 0;
                      foreach ($combinedData_cash_out as $date => $data) :
                        ?>
                          <tr class="even pointer">
                            
                            
                            <td class=" "><?= $date ?> </td>
                            <td class=" "><?= number_format( $data['total_cashouts'] ,2) ?></td>
                            <?php $totalamount += $data['total_cashouts'] ?>
                            
                          </tr>
                          
                          <?php endforeach; ?>
                         
                        </tbody>
                        <tfoot>
                    <tr>
                      <td colspan=""><strong> Total Amount</strong>
                      </td>
                      <td>
                        <strong><?= number_format(@$totalamount, 2) ?></strong>
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
      labels: [<?= "'" . implode("','", $datesArray_cash_out) . "'" ?>],
      datasets: [{
        label: 'Cashouts',
        data: [<?=  implode(",", $netTotalArray_cash_out) ?>],
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