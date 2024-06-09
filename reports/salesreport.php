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
            <h2>Sales Report</h2>
            <ul class="nav navbar-right panel_toolbox">
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group ml-1">
              <a href="<?= SYSTEM_PATH ?>reports/sales_report_details.php" class="btn btn-sm btn-outline-secondary">More Filter</a>
              </div>
              
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

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Sales Cost Report</h2>
            <ul class="nav navbar-right panel_toolbox">
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group ml-1">
                <a href="<?= SYSTEM_PATH ?>reports/sales_cost_report_details.php" class="btn btn-sm btn-outline-secondary"> More Filter</a>
              </div>
              
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          <div class="demo-container" style="height:250px">
            <div class="demo-placeholder">
              <canvas id="salescostchart" style="width:95%;height: 90%"></canvas>
            </div>

             
         </div>
        </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Cashout Chart</h2>
            <ul class="nav navbar-right panel_toolbox">
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group ml-1">
                <a href="<?= SYSTEM_PATH ?>reports/cashout_report_details.php" class="btn btn-sm btn-outline-secondary"> More Filter</a>
              </div>
              
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          <div class="demo-container" style="height:250px">
            <div class="demo-placeholder">
              <canvas id="cashoutchart" style="width:95%;height: 90%"></canvas>
            </div>

             
         </div>
        </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Discounts Chart</h2>
            <ul class="nav navbar-right panel_toolbox">
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group ml-1">
                <a href="<?= SYSTEM_PATH ?>reports/discounts_report_details.php" class="btn btn-sm btn-outline-secondary"> More Filter</a>
              </div>
              
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          <div class="demo-container" style="height:250px">
            <div class="demo-placeholder">
              <canvas id="discountcharts" style="width:95%;height: 90%"></canvas>
            </div>

             
         </div>
        </div>
        </div>
      </div>
    </div>

    <!-- <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Cost Report</h2>
            <ul class="nav navbar-right panel_toolbox">
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group ml-1">
                <a href="<?= SYSTEM_PATH ?>reports/cost_report_details.php" class="btn btn-sm btn-outline-secondary"> More Filter</a>
              </div>
              
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          <div class="demo-container" style="height:250px">
            <div class="demo-placeholder">
              <canvas id="myChart3" style="width:95%;height: 90%"></canvas>
            </div>

             
         </div>
        </div>
        </div>
      </div>
    </div> -->

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Profit and Loss Report</h2>
            <ul class="nav navbar-right panel_toolbox">
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group ml-1">
                <a href="<?= SYSTEM_PATH ?>reports/porfit_and_loss_report.php" class="btn btn-sm btn-outline-secondary"> Filter</a>
              </div>
             
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          <div class="demo-container" style="height:250px">
            <div class="demo-placeholder">
              <canvas id="myChart4" style="width:95%;height: 90%"></canvas>
            </div>

             <div id="chart_plot_03" ></div>
         </div>
        </div>
        </div>
      </div>
    </div>
  


  </div>
</div>

<!-- sales report php sql code start -->
<?php
//        SELECT op.productid, imi.productid, tp.ProductID , tp.ProductCategory , imi.price FROM `orderproducts` op INNER JOIN tbl_imie imi on op.productid= imi.productid INNER JOIN tbl_products tp on op.productid=tp.ProductID;
        //$sqldiscount = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleAmount) AS total_sale FROM tbl_sales WHERE SaleDate >= CURDATE() - INTERVAL 6 DAY GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
        
        $sql_sevenday_sales=" SELECT date_range.date AS sale_day, COALESCE(SUM(s.SaleAmount), 0) AS total_sale
        FROM (
            SELECT CURDATE() - INTERVAL n DAY AS date
            FROM (
                SELECT @row := @row - 1 AS n
                FROM information_schema.columns, (SELECT @row := 7) r
                LIMIT 7
            ) dates
        ) date_range
        LEFT JOIN tbl_sales s ON date_range.date = DATE(s.SaleDate)
        GROUP BY date_range.date
        ORDER BY date_range.date DESC;
        ";
        $db = dbConn();
        $result_sevenday_sales = $db->query($sql_sevenday_sales);

        $data_labeldiscount = array();
        $data_valuediscount = array();

        while ($row_sevenday_sales = $result_sevenday_sales->fetch_assoc()) {
            $data_labeldiscount[] = $row_sevenday_sales['total_sale'];
            $data_valuediscount[] = $row_sevenday_sales['sale_day'];
        }
         "<br>";
         "'" . implode("','", $data_valuediscount) . "'";
         implode(",", $data_labeldiscount);
        ?>
<!-- sales report php sql code end -->


<!-- cost report data manipulating starts -->
<?php 
       
        $to = date('Y-m-d');
        $from =date('Y-m-d', strtotime('-6 days', strtotime($to)));

        // Perform the first query with date range
        $query1 = "SELECT DATE(Addeddate) AS Cashout_day, SUM(Amountcashout) AS total_cashouts FROM tbl_cashout WHERE Addeddate BETWEEN '$from' AND '$to' GROUP BY DATE(Addeddate) ORDER BY DATE(Addeddate) DESC";
        $result1 =  $db->query($query1);
         "<br>";
        // Perform the second query with date range
       $query2 = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleCost) AS total_cost FROM tbl_sales WHERE SaleDate BETWEEN '$from' AND '$to' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
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
                $combinedData[$date]['net_total'] = $row2['total_cost'] + $combinedData[$date]['total_cashouts'];
            } else {
                $combinedData[$date] = array(
                    'total_cost' => $row2['total_cost'],
                    'total_cashouts' => 0,
                    'net_total' => $row2['total_cost']
                );
            }
            $netTotalArray[] = $combinedData[$date]['net_total'];
        }
        // Sort the array in descending order by date
        krsort($combinedData);
        rsort($datesArray);
         "<br>";
        ($datesArray);
         "<br>";
        ($netTotalArray);
         "<br>";
         "'" . implode("','", $datesArray) . "'";
        //print_r($datesArray);
         "<br>";
         implode(",", $netTotalArray);
         "<br>";
        
?>
<!-- cost report data manipulating ends -->

<!-- starting the profit chart  -->

<?php 
      //   $from =date('Y-m-d', strtotime('-6 days', strtotime($to)));
      //   $to = date('Y-m-d');

      //   // Perform the first query with date range
      //  echo $query1 = "SELECT DATE(Addeddate) AS Cashout_day, SUM(Amountcashout) AS total_cashouts FROM tbl_cashout WHERE Addeddate BETWEEN '$from' AND '$to' GROUP BY DATE(Addeddate) ORDER BY DATE(Addeddate) DESC";
      //   $result1 =  $db->query($query1);
      //   echo "<br>";
      //   // Perform the second query with date range
      //   echo $query2 = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleCost) AS total_cost ,SUM(SaleProfit) AS total_profit FROM tbl_sales WHERE SaleDate BETWEEN '$from' AND '$to' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
      //   $result2 =  $db->query($query2);

      //   // Fetch results and combine based on date
      //   $combinedData = array();
      //   $datesArray = array();
      //   $netTotalArray = array();

      //   while ($row1 = mysqli_fetch_assoc($result1)) {
      //       $date = $row1['Cashout_day'];
      //       $datesArray[] = $date;
      //       $combinedData[$date] = array('total_cashouts' => $row1['total_cashouts']);
      //   }

      //   while ($row2 = mysqli_fetch_assoc($result2)) {
      //       $date = $row2['sale_day'];
      //       if (!in_array($date, $datesArray)) {
      //           $datesArray[] = $date;
      //       }
          
      //       if (isset($combinedData[$date])) {
      //           $combinedData[$date]['total_cost'] = $row2['total_cost'];
      //           $combinedData[$date]['net_total'] = $row2['total_cost'] + $combinedData[$date]['total_cashouts'];
      //           $combinedData[$date]['net_profit'] = ($row2['total_profit'] - ($row2['total_cost'] + $combinedData[$date]['total_cashouts']));
      //       } else {
      //           $combinedData[$date] = array(
      //               'total_cost' => $row2['total_cost'],
      //               'total_cashouts' => 0,
      //               'net_total' => $row2['total_cost'],
      //               'total_profit' => $row2['total_profit'] - $row2['total_cost'],
      //           );
      //       }
      //       $netTotalArray[] = $combinedData[$date]['net_total'];
      //       $netprofitArray[] = $combinedData[$date]['total_profit'];
      //   }
      //   // Sort the array in descending order by date
      //   krsort($combinedData);
      //   rsort($datesArray);
      //   echo "<br>";
      //   print_r($datesArray);
      //   echo "<br>";
      //   print_r($netTotalArray);
      //   echo "<br>";
      //  echo  "'" . implode("','", $datesArray) . "'";
      //   //print_r($datesArray);
      //   echo "<br>";
      //   echo implode(",", $netTotalArray);
      //   echo "<br>";
        
?>
<!-- starting the profit chart  -->


<!-- starting of sales cost chart -->
<?php 
       $to = date('Y-m-d');
       $from =date('Y-m-d', strtotime('-6 days', strtotime($to)));
       
       $db = dbConn();
        // Perform the first query with date range
     
        
        // Perform the second query with date range
         $query_sales_cost_2 = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleCost) AS total_cost FROM tbl_sales WHERE SaleDate BETWEEN '$from' AND '$to' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
         $result_sales_cost_2 =  $db->query($query_sales_cost_2);

        // Fetch results and combine based on date
        $combinedData_sales_cost = array();
        $datesArray_sales_cost = array();
        $netTotalArray_sales_cost = array();

        while ($row2 = mysqli_fetch_assoc($result_sales_cost_2)) {
          $date = $row2['sale_day'];
          if (!in_array($date, $datesArray_sales_cost)) {
              $datesArray_sales_cost[] = $date;
          }
        
          if (isset($combinedData_sales_cost[$date])) {
            if (!in_array($date, $datesArray_sales_cost)) {
            $datesArray[] = $date;}

              $combinedData_sales_cost[$date]['total_cost'] = $row2['total_cost'];
              
              
          } else {
              $combinedData_sales_cost[$date] = array(
                  'total_cost' => $row2['total_cost'],
                  
              ); 
          }
          $netTotalArray_sales_cost[] = $combinedData_sales_cost[$date]['total_cost'];
      }

      


        // Sort the array in descending order by date
         "<br>";
        krsort($combinedData_sales_cost);
        rsort($datesArray_sales_cost);
        rsort($datesArray_sales_cost);
       
         "'" . implode("','", $datesArray_sales_cost) . "'";
        //print_r($datesArray);
         "<br>";
          implode(",", $netTotalArray_sales_cost);

?>
<!-- end of the sales cost chart -->



<!-- start of the cashout chart -->
<?php 
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

?>
<!-- end of the cash out chart -->


<!-- start of the discount chart  -->
<?php
//        SELECT op.productid, imi.productid, tp.ProductID , tp.ProductCategory , imi.price FROM `orderproducts` op INNER JOIN tbl_imie imi on op.productid= imi.productid INNER JOIN tbl_products tp on op.productid=tp.ProductID;
        //$sqldiscount = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleAmount) AS total_sale FROM tbl_sales WHERE SaleDate >= CURDATE() - INTERVAL 6 DAY GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
        
        $sql_sevenday_sales="SELECT date_range.date AS sale_day, COALESCE(SUM(s.SaleDiscount), 0) AS total_discount, COALESCE(SUM(s.SalesSpecialdiscounts), 0) AS total_special_discount FROM ( SELECT CURDATE() - INTERVAL n DAY AS date FROM ( SELECT @row := @row - 1 AS n FROM information_schema.columns, (SELECT @row := 7) r LIMIT 7 ) dates ) date_range LEFT JOIN tbl_sales s ON date_range.date = DATE(s.SaleDate) GROUP BY date_range.date ORDER BY date_range.date DESC;
        ";
        $db = dbConn();
        $result_sevenday_sales = $db->query($sql_sevenday_sales);

        $data_label_discount_total = array();
        $data_value_discount_total= array();

        while ($row_sevenday_sales = $result_sevenday_sales->fetch_assoc()) {
          $data_label_discount_total[] = $row_sevenday_sales['total_discount'] + $row_sevenday_sales['total_special_discount'];
          $data_value_discount_total[] = $row_sevenday_sales['sale_day'];
        }
          "<br>";
          "'" . implode("','", $data_value_discount_total) . "'";
          implode(",", $data_label_discount_total);
        ?>
<!-- end of the discount chart -->



<!-- start of the profit and loss php -->
<?php
    // Your database connection code here
    
    $db = dbConn();
    // Check if the form is submitted
    
        // Get the start and end dates from the form
        $to = date('Y-m-d');
        $ $from =date('Y-m-d', strtotime('-6 days', strtotime($to)));
        // Perform the first query with date range
        $query_profit_and_loss = "SELECT DATE(Addeddate) AS Cashout_day, SUM(Amountcashout) AS total_cashouts FROM tbl_cashout WHERE Addeddate BETWEEN '$from' AND '$to' GROUP BY DATE(Addeddate) ORDER BY DATE(Addeddate) DESC";
        $result_profit_and_loss =  $db->query($query_profit_and_loss);
        // Perform the second query with date range
         $query_profit_and_loss_2 = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleCost) AS total_cost ,SUM(SaleProfit) AS total_profit ,SUM(SaleDiscount) AS total_discounts,SUM(SalesSpecialdiscounts) AS total_special_discount FROM tbl_sales WHERE SaleDate BETWEEN '$from' AND '$to' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
        $result_profit_and_loss_2 =  $db->query($query_profit_and_loss_2);

        // Fetch results and combine based on date
        $combinedData_profit_and_loss = array();
        $datesArray_profit_and_loss = array();
        $netTotalArray_profit_and_loss = array();

        while ($row_profit_and_loss_1 = mysqli_fetch_assoc($result_profit_and_loss)) {
            $date = $row_profit_and_loss_1['Cashout_day'];
            $datesArray_profit_and_loss[] = $date;
            $combinedData_profit_and_loss[$date] = array('total_cashouts' => $row_profit_and_loss_1['total_cashouts']);
        }

        while ($row_profit_and_loss_2 = mysqli_fetch_assoc($result_profit_and_loss_2)) {
            $date = $row_profit_and_loss_2['sale_day'];
            if (!in_array($date, $datesArray_profit_and_loss)) {
                $datesArray_profit_and_loss[] = $date;
            }
          
            if (isset($combinedData_profit_and_loss[$date])) {
                $combinedData_profit_and_loss[$date]['total_cost'] = $row_profit_and_loss_2['total_cost'];
                $combinedData_profit_and_loss[$date]['total_special_discount'] = $row_profit_and_loss_2['total_special_discount'];
                $combinedData_profit_and_loss[$date]['total_discounts'] = $row_profit_and_loss_2['total_discounts'];
                $combinedData_profit_and_loss[$date]['total_profit'] = $row_profit_and_loss_2['total_profit'];
                $combinedData_profit_and_loss[$date]['net_total'] = ($row_profit_and_loss_2['total_cost'] + $combinedData_profit_and_loss[$date]['total_cashouts'] + $row_profit_and_loss_2['total_discounts'] +  $row_profit_and_loss_2['total_special_discount']);
                $combinedData_profit_and_loss[$date]['net_totalz'] = ( @$combinedData_profit_and_loss[$date]['total_cashouts'] + $row_profit_and_loss_2['total_discounts'] +  $row_profit_and_loss_2['total_special_discount']);
            } else {
                $combinedData_profit_and_loss[$date] = array(
                    'total_cost' => $row_profit_and_loss_2['total_cost'],
                    'total_cashouts' => 0,
                    'net_total' => ($row_profit_and_loss_2['total_cost'] + $row_profit_and_loss_2['total_discounts'] +  $row_profit_and_loss_2['total_special_discount']),
                    'total_discounts' => $row_profit_and_loss_2['total_discounts'],
                    'total_special_discount' => $row_profit_and_loss_2['total_special_discount'],
                    'total_profit'  => $row_profit_and_loss_2['total_profit'],
                    'net_totalz' => @$combinedData_profit_and_loss[$date]['total_cashouts'] + $row_profit_and_loss_2['total_discounts'] +  $row_profit_and_loss_2['total_special_discount']
                ); 
            }
            $netTotalArray_profit_and_loss[] = $combinedData_profit_and_loss[$date]['total_profit'] - $combinedData_profit_and_loss[$date]['net_totalz'];
        }

        // Sort the array in descending order by date
        krsort($combinedData_profit_and_loss);
        rsort($datesArray_profit_and_loss);
       
        //print_r($datesArray);
       
        
        
        //print_r($netTotalArray);
    
    ?>
<!-- end of the profit and loss php -->

<!-- /page content -->
<script>
  const ctx = document.getElementById('myChart1');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: [<?= "'" . implode("','", $data_valuediscount) . "'" ?>],
      datasets: [{
        label: 'Sales',
        data: [<?=  implode(",", $data_labeldiscount) ?>],
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

<script>
  const ctx1 = document.getElementById('myChart3');
  new Chart(ctx1, {
    type: 'line',
    data: {
      labels: [<?=  "'" . implode("','", $datesArray) . "'"?>],
      datasets: [{
        label: 'Cost',
        data: [<?= implode(",", $netTotalArray) ?>],
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

<!-- sales cost script starts -->
<script>
  const ctx11 = document.getElementById('salescostchart');
  new Chart(ctx11, {
    type: 'line',
    data: {
      labels: [<?=  "'" . implode("','", $datesArray_sales_cost) . "'"?>],
      datasets: [{
        label: 'Sales Cost',
        data: [<?= implode(",", $netTotalArray_sales_cost) ?>],
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
<!-- sales cost script ends -->


<!-- cashout script starts -->
<script>
  const ctx12 = document.getElementById('cashoutchart');
  new Chart(ctx12, {
    type: 'line',
    data: {
      labels: [<?=  "'" . implode("','", $datesArray_cash_out) . "'"?>],
      datasets: [{
        label: 'Cash outs',
        data: [<?= implode(",", $netTotalArray_cash_out) ?>],
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
<!-- cashout script ends -->

<!-- start of the discount -->
<script>
  const ctx21 = document.getElementById('discountcharts');
  new Chart(ctx21, {
    type: 'line',
    data: {
      labels: [<?=  "'" . implode("','", $data_value_discount_total) . "'"?>],
      datasets: [{
        label: 'Discounts',
        data: [<?= implode(",", $data_label_discount_total ) ?>],
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
<!-- end of the discount -->


<script>
  const ctx22 = document.getElementById('myChart4');
  new Chart(ctx22, {
    type: 'line',
    data: {
      labels: [<?=  "'" . implode("','", $datesArray_profit_and_loss) . "'"?>],
      datasets: [{
        label: 'Profit & Loss',
        data: [<?= implode(",", $netTotalArray_profit_and_loss ) ?>],
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
<script>
  const ctx3 = document.getElementById('myChart7');
  new Chart(ctx3, {
    type: 'line',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [65, 59, 80, 81, 56, 55, 40],
        borderWidth: 1,
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