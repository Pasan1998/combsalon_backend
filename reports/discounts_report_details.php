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
            <h2>Discount  Report</h2>
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
                    <input type="date" class="form-control" name="to" placeholder="Enter From Date" max="<?php echo date('Y-m-d'); ?>" required=true  >
                  

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
   $query_discount_filter = "SELECT DATE(SaleDate) AS Cashout_day, SUM(SaleDiscount) AS total_discounts , SUM(SalesSpecialdiscounts) AS total_discounts_special , SUM(SaleDiscount + SalesSpecialdiscounts ) AS sum_of_discounts FROM tbl_sales WHERE SaleDate BETWEEN '$from_date' AND '$to_date' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
   $result_discount_filter =  $db->query($query_discount_filter);
      $data_label_discount_total = array();
   $data_value_discount_total= array();

   while ($row_discount_filter = $result_discount_filter->fetch_assoc()) {
     $data_label_discount_total[] = $row_discount_filter['total_discounts'] + $row_discount_filter['total_discounts_special'];
     $data_value_discount_total[] = $row_discount_filter['Cashout_day'];
   }

     "'" . implode("','", $data_value_discount_total) . "'";
     implode(",", $data_label_discount_total);
   
              }
             ?>

<!-- filtering code ends -->

    <div class="row">
      

          
           
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Discount Table <small></small></h2>
                    <u$row_discount_filterl class="nav navbar-right panel_toolbox">
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
                    </u$row_discount_filterl>
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
    $query_cash_out = "SELECT DATE(SaleDate) AS Cashout_day, SUM(SaleDiscount) AS total_discounts , SUM(SalesSpecialdiscounts) AS total_discounts_special , SUM(SaleDiscount + SalesSpecialdiscounts ) AS sum_of_discounts FROM tbl_sales WHERE SaleDate BETWEEN '$from' AND '$to' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
   $result_discount_filter =  $db->query($query_cash_out);

  //  $data_label_discount_total = array();
  //  $data_value_discount_total= array();

  //  while ($row_discount_filter = $result_discount_filter->fetch_assoc()) {
  //    $data_label_discount_total[] = $row_discount_filter['total_discounts'] + $row_discount_filter['total_discounts_special'];
  //    $data_value_discount_total[] = $row_discount_filter['Cashout_day'];
  //  }
  //  echo  "<br>";
  //  echo  "'" . implode("','", $data_value_discount_total) . "'";
  //   echo implode(",", $data_label_discount_total);
  
       
}else{
  extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $where = 10;
             $to_date = $to;
             $from_date = $from;
             
             $db = dbConn();
   // Perform the first query with date range
   $query_discount_filter = "SELECT DATE(SaleDate) AS Cashout_day, SUM(SaleDiscount) AS total_discounts , SUM(SalesSpecialdiscounts) AS total_discounts_special , SUM(SaleDiscount + SalesSpecialdiscounts ) AS sum_of_discounts FROM tbl_sales WHERE SaleDate BETWEEN '$from_date' AND '$to_date' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
   $result_discount_filter =  $db->query($query_discount_filter);
      $data_label_discount_total = array();
   $data_value_discount_total= array();

  
   
              }
}


?>
<!-- sales report php sql code end -->
                        <tbody>
                        <?php
                  
                      $i = 1;
                      $totalamount = 0;
                      if ($result_discount_filter->num_rows > 0) {
                        while ($row_discount_filter = $result_discount_filter->fetch_assoc()) {
                        ?>
                          <tr class="even pointer">
                            
                            
                            <td class=" "><?= $row_discount_filter ['Cashout_day'] ?> </td>
                            <td class=" "><?=
                             number_format( $row_discount_filter ['sum_of_discounts'] ,2) ?></td>
                              <?php $totalamount += $row_discount_filter['sum_of_discounts'] ?>
                            
                          </tr>
                          
                          <?php }} ?>
                         
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



<?php 
if (@$where == null) {
 
  $to = date('Y-m-d');
  $from =date('Y-m-d', strtotime('-6 days', strtotime($to)));
  
  $db = dbConn();
   // Perform the first query with date range
    $query_cash_out = "SELECT DATE(SaleDate) AS Cashout_day, SUM(SaleDiscount) AS total_discounts , SUM(SalesSpecialdiscounts) AS total_discounts_special , SUM(SaleDiscount + SalesSpecialdiscounts ) AS sum_of_discounts FROM tbl_sales WHERE SaleDate BETWEEN '$from' AND '$to' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
   $result_discount_filter =  $db->query($query_cash_out);

   $data_label_discount_total = array();
   $data_value_discount_total= array();

   while ($row_discount_filter = $result_discount_filter->fetch_assoc()) {
     $data_label_discount_total[] = $row_discount_filter['total_discounts'] + $row_discount_filter['total_discounts_special'];
     $data_value_discount_total[] = $row_discount_filter['Cashout_day'];
   }
     "<br>";
     "'" . implode("','", $data_value_discount_total) . "'";
     implode(",", $data_label_discount_total);
  
       
}


?>
    <?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $where = 10;
             $to_date = $to;
             $from_date = $from;
             
             $db = dbConn();
   // Perform the first query with date range
   $query_discount_filter = "SELECT DATE(SaleDate) AS Cashout_day, SUM(SaleDiscount) AS total_discounts , SUM(SalesSpecialdiscounts) AS total_discounts_special , SUM(SaleDiscount + SalesSpecialdiscounts ) AS sum_of_discounts FROM tbl_sales WHERE SaleDate BETWEEN '$from_date' AND '$to_date' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
   $result_discount_filter =  $db->query($query_discount_filter);
      $data_label_discount_total = array();
   $data_value_discount_total= array();

   while ($row_discount_filter = $result_discount_filter->fetch_assoc()) {
     $data_label_discount_total[] = $row_discount_filter['total_discounts'] + $row_discount_filter['total_discounts_special'];
     $data_value_discount_total[] = $row_discount_filter['Cashout_day'];
   }
     "<br>";
     "'" . implode("','", $data_value_discount_total) . "'";
     implode(",", $data_label_discount_total);
   
              }
             ?>

<script>
  const ctx = document.getElementById('myChart1');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: [<?= "'" . implode("','", $data_value_discount_total) . "'" ?>],
      datasets: [{
        label: 'Discounts',
        data: [<?=  implode(",", $data_label_discount_total) ?>],
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