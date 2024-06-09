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
                   
                    <input type="date" class="form-control" name="from" placeholder="Enter From Date" max="<?php echo date('Y-m-d'); ?>"  required="true">
                    </div>
                    <div class="col-sm">
                    <input type="date" class="form-control" name="to" placeholder="Enter From Date" max="<?php echo date('Y-m-d'); ?>" required="true">
                  

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
              $query1 = "SELECT DATE(Addeddate) AS Cashout_day, SUM(Amountcashout) AS total_cashouts FROM tbl_cashout WHERE Addeddate BETWEEN '$from_date' AND '$to_date' GROUP BY DATE(Addeddate) ORDER BY DATE(Addeddate) DESC";
              $result1 =  $db->query($query1);
              
              // Perform the second query with date range
               $query2 = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleCost) AS total_cost FROM tbl_sales WHERE SaleDate BETWEEN '$from_date' AND '$to_date' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
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
              rsort($datesArray);
             
               "'" . implode("','", $datesArray) . "'";
              //print_r($datesArray);
           
               implode(",", $netTotalArray);}
             ?>

<!-- filtering code ends -->

    <div class="row">
      

          
           
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Sales Table <small></small></h2>
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
                            <th class="column-title">Sum of CashOut </th>
                            <th class="column-title">Net Cost </th>
                          </tr>
                        </thead>
                        
<?php 
if (@ $where == null) {
 
       $to = date('Y-m-d');
       $from =date('Y-m-d', strtotime('-6 days', strtotime($to)));
       
       $db = dbConn();
        // Perform the first query with date range
        $query1 = "SELECT DATE(Addeddate) AS Cashout_day, SUM(Amountcashout) AS total_cashouts FROM tbl_cashout WHERE Addeddate BETWEEN '$from' AND '$to' GROUP BY DATE(Addeddate) ORDER BY DATE(Addeddate) DESC";
        $result1 =  $db->query($query1);
        
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
        rsort($datesArray);
       
         "'" . implode("','", $datesArray) . "'";
        //print_r($datesArray);
     
         implode(",", $netTotalArray);
       
       
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
                            <td class=" "><?= number_format( $data['total_cost'] ,2) ?></td>
                            <td class=" "><?= number_format($data['total_cashouts']  ,2)?></td>
                            <td class=" "><?= number_format($data['net_total'] ,2) ?></td>
                            
                          </tr>
                          
                          <?php endforeach; ?>
                         
                        </tbody>
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
        label: '# of Votes',
        data: [<?=  implode(",", $netTotalArray) ?>],
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

<script>
  const ctx1 = document.getElementById('myChart3');
  new Chart(ctx1, {
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
<script>
  const ctx2 = document.getElementById('myChart4');
  new Chart(ctx2, {
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