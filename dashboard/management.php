<div class="right_col" role="main">
  <div class="row" style="display: inline-block;">
    <div class="tile_count">
      <div class="col-md-3 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Today Total Sales</span>
        <?php 
        $db=dbConn();
        $sqltodaysale="SELECT SUM(SaleAmount) AS total_sale FROM tbl_sales WHERE DATE(SaleDate) = CURDATE()";
        $resulttodaysale = $db->query($sqltodaysale);
        if ($resulttodaysale->num_rows > 0){
          $rowtodaysale = $resulttodaysale->fetch_assoc();
          $total_sale=$rowtodaysale['total_sale'];
        }else{
          $total_sale = 0;
        }
        ?>
        <div class="count"><?= number_format($total_sale,2) ?></div>
        <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
      </div>
      <div class="col-md-3 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Today Total Cash Sale </span>
        
        <?php 
        $db=dbConn();
        $sqltodaysalecash="SELECT SUM(SaleAmount) AS total_salecash FROM tbl_sales WHERE DATE(SaleDate) = CURDATE() and PaymentType = '1'";
        $resulttodaysalecash = $db->query($sqltodaysalecash);
        if ($resulttodaysalecash->num_rows > 0){
          $rowtodaysalecash = $resulttodaysalecash->fetch_assoc();
          $sale_cash=$rowtodaysalecash['total_salecash'];
        }else{
          $sale_cash = 0;  
        }
        ?>

      

        <div class="count "><?= number_format( $sale_cash, 2)  ?></div>
        <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
      </div>
      <div class="col-md-3 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Today Total Service Cost</span>
        
        <?php 
        $db=dbConn();
        $sqltodaysalecost="SELECT SUM(SaleCost) AS total_cost FROM tbl_sales WHERE DATE(SaleDate) = CURDATE();";
        $resulttodaysalecost = $db->query($sqltodaysalecost);
        if ($resulttodaysalecost->num_rows > 0){
          $rowtodaysalecost = $resulttodaysalecost->fetch_assoc();
          $sale_cost=$rowtodaysalecost['total_cost'];
        }else{
          $sale_cost = 0;  
        }
        ?>

      

        <div class="count "><?= number_format( $sale_cost, 2)  ?></div>
        <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
      </div>
   
      <div class="col-md-3 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Today Total Discounts</span>
        <?php 
        $db=dbConn();
         $sqltodaydiscount="SELECT SUM(SaleServiceDiscount) AS total_discount FROM tbl_sales_services WHERE DATE(SaleServiceAddedDate) = CURDATE();";
        $resulttodaydiscount = $db->query($sqltodaydiscount);

         $sqltodayspecialdiscount="SELECT SUM(SalesSpecialdiscounts) AS total_special_discount FROM tbl_sales WHERE DATE(SaleDate) = CURDATE();";
        $resulttodayspecialdiscount = $db->query($sqltodayspecialdiscount);

        if ($resulttodaydiscount->num_rows > 0 || $resulttodayspecialdiscount->num_rows > 0 ){
          $rowtodaydiscount = $resulttodaydiscount->fetch_assoc();
          $rowtodayspecialdiscount = $resulttodayspecialdiscount->fetch_assoc();
          @$normal_discount=$rowtodaydiscount['total_discount'];
          @$special_discount=$rowtodayspecialdiscount['total_special_discount'];
          @$summery_discount = @$normal_discount +  @$special_discount;
        }else{
          $summery_discount= 0;
        }
        ?>

        <div class="count "><?= number_format( $summery_discount, 2)  ?></div>
        <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
      </div>
      <div class="col-md-3 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Today Total Sale Profit</span>
        <?php 
        $db=dbConn();
        $sqltodaytotalprofit="SELECT SUM(SaleProfit) AS total_profitt FROM tbl_sales WHERE DATE(SaleDate) = CURDATE()";
        $resulttodaytotalprofit = $db->query($sqltodaytotalprofit);
        if ($resulttodaytotalprofit->num_rows > 0){
          $rowtodayprofit = $resulttodaytotalprofit->fetch_assoc();
          $sale_total_profit=$rowtodayprofit['total_profitt'];
        }else{
          $sale_total_profit= 0;  
        }
        ?>
        <div class="count "><?= number_format($sale_total_profit,2) ?></div>
        <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
      </div>
      
      <div class="col-md-3 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i>Totay Customers</span>
        <?php 
        $db=dbConn();
        //$sqltodaycustomers="SELECT COUNT(SalesID) AS total_customer FROM tbl_sales WHERE DATE(SaleDate) = CURDATE();";
        $sqltodaycustomers="SELECT COUNT(DISTINCT CustomerName) AS total_customers FROM tbl_sales WHERE DATE(SaleDate) = CURDATE()";
        $resulttodaycustomers = $db->query($sqltodaycustomers);
        if ($resulttodaycustomers->num_rows > 0){
          $rowtodaycustomers = $resulttodaycustomers->fetch_assoc();
          $customer=$rowtodaycustomers['total_customers'];
        }else{
          $customer= 0;  
        }
        ?>
        <div class="count"><?= $customer ?></div>
        <!-- <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span> -->
      </div>
      <div class="col-md-3 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i>Totay Management Cashouts</span>
        <?php 
        $db=dbConn();
        $sql_today_cashout_management="SELECT SUM(Amountcashout) AS management_cashouts FROM tbl_cashout WHERE DATE(Addeddate) = CURDATE() AND cashoutusertype = 'management'";
        $result_today_cashout_management = $db->query($sql_today_cashout_management);
        if ($result_today_cashout_management->num_rows > 0){
          $row_today_cashout_management = $result_today_cashout_management->fetch_assoc();
          $management_cashouts=$row_today_cashout_management['management_cashouts'];
        }else{
          $management_cashouts= 0;  
        }
        ?>
        <div class="count"><?= number_format( $management_cashouts,2) ?></div>
        <!-- <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span> -->
      </div>
      <div class="col-md-3 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i>Totay Staff Cashouts</span>
        <?php 
        $db=dbConn();
        $sql_today_cashout_staff="SELECT SUM(Amountcashout) AS staff_cashouts FROM tbl_cashout WHERE DATE(Addeddate) = CURDATE() AND cashoutusertype = 'stylist'";
        $result_today_cashout_staff = $db->query($sql_today_cashout_staff);
        if ($result_today_cashout_staff->num_rows > 0){
          $row_today_cashout_staff = $result_today_cashout_staff->fetch_assoc();
          $staff_cashouts=$row_today_cashout_staff['staff_cashouts'];
        }else{
          $staff_cashouts= 0;  
        }
        ?>
        <div class="count"><?= number_format( $staff_cashouts,2) ?></div>
        <!-- <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span> -->
      </div>
     
      <div class="col-md-3 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i>Today Net Profit</span>
        <?php 
        
        $sale_total_net_profit = ($sale_total_profit -( $staff_cashouts + $management_cashouts ))
        ?>
        <?php if ($sale_total_net_profit > 0){
          $color= 'green';
        }else{
          $color= 'red';
        } ?>
        <div class="count <?= $color ?>"><?= number_format($sale_total_net_profit,2) ?></div>
        <!-- <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span> -->
      </div>
      


    </div>
  </div>
  <br />
  <style>
        /* Add your custom styles here */
        .blue { color: #FF6384; }
        .green { color: #36A2EB; }
        .purple { color: #FFCE56; }
        .aero { color: #4BC0C0; }
        /* Add more styles for other colors */
    </style>

  <div class="row">
    <div class="col-md-12 col-sm-12 ">
      <div class="dashboard_graph x_panel">
        <div class="x_title">
          <div class="col-md-6">
            <h3>This Week Sales <small>Graph title sub-title</small></h3>
          </div>
          <div class="col-md-6">
            <div id="" class="pull-right"
              style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
             
              <?php
$currentDate = date("F j, Y", strtotime("today"));
$fourteenDaysAgo = date("F j, Y", strtotime("-14 days")); 

?>

              <div><?= $fourteenDaysAgo  ?> - <?=  $currentDate; ?></div>
               <!-- <b class="caret"></b> -->
            </div>
          </div>
        </div>
        <div class="x_content">
          <div class="demo-container" style="height:250px">
            <div class="demo-placeholder">
           <canvas id="myChart20" style="width:100%;height: 90%"></canvas> 
         
            </div>


          </div>
        </div>
      </div>
    </div>
  </div>


  
  <div class="row">
  <div class="col-md-6 col-sm-6 ">
      <div class="x_panel tile fixed_height_320">
        <div class="x_title">
          <h2>Today Stylist Sales <small>Contributions</small></h2>
          <ul class="nav navbar-right panel_toolbox">
            
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table class="" style="width:100%">
            <tr>
              <th style="width:37%;">
                <p>Contribution</p>
              </th>
              <th>
                <div class="col-lg-4 col-md-4 col-sm-4 ">
                  <p class="">Stylist</p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 ">
                  <p class="">Amount</p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 ">
                  <p class="">Percentage</p>
                </div>
              </th>
            </tr>
            <tr>
              <td>
                <canvas id="myDoughnutChart" class="myDoughnutChart" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
              </td>
              <td>
                <!-- start php generating for stylist sales pie chart -->
<?php 
 

$sql_single_day_totalsale="SELECT SUM(SaleServiceSale) AS OverallTotalSales FROM tbl_sales_services WHERE DATE(SaleServiceAddedDate) = CURDATE()";
$db = dbConn();
$result_single_day_totalsale = $db->query($sql_single_day_totalsale);
$row_single_day_totalsale = $result_single_day_totalsale->fetch_assoc();
 $today_sale_sum = $row_single_day_totalsale['OverallTotalSales'];


 $sql_single_sale_emp="SELECT 
 EmplyoeeID, 
 SUM(SaleServiceSale) AS TotalSales , EmpFName,EmpLName
FROM 
 tbl_sales_services LEFT JOIN tbl_emp on tbl_sales_services.EmplyoeeID = tbl_emp.EmpId
WHERE 
 DATE(SaleServiceAddedDate) = CURDATE() 
GROUP BY 
 EmplyoeeID";




 $db = dbConn();
 $result_single_sale_emp = $db->query($sql_single_sale_emp);
?>

<!-- end php generating for stylist sales pie chart -->
                <table class="tile_info">
                <?php
 if ($result_single_sale_emp->num_rows > 0) {
 while ($row_single_sale_emp = $result_single_sale_emp->fetch_assoc()) {
 ?>
                  <tr>
                    <td>
                      <p><i class="fa fa-square color-icon"></i> <?= ucwords( $row_single_sale_emp['EmpFName']) . " " . ucwords($row_single_sale_emp['EmpLName'] )?> </p>
                    </td>
                    <td><?= $row_single_sale_emp['TotalSales'] ?></td>
                    <td><?php $emp_today_sale = $row_single_sale_emp['TotalSales'];
                   echo number_format(( $emp_today_sale /$today_sale_sum )*100) ;
                    
                    ?>%</td>
                  </tr>
                  <?php }}?>
                  
                
                </table>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-sm-6 ">
      <div class="x_panel fixed_height_320">
        <div class="x_title">
          <h2>Today Service <small>Sessions</small></h2>
          <ul class="nav navbar-right panel_toolbox">
           
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
         
          <div class="demo-container" style="" >
            <div class="demo-placeholder">
            <div id="chart_div" ></div>
            </div>
          </div>

        </div>
      </div>
    </div>

    
      </div>

    <div class="row">
    <!-- <div class="col-md-6 col-sm-6  widget_tally_box">
      <div class="x_panel">
        <div class="x_title">
          <h2>This Week Profit</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
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
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

        <canvas id="myBarChart21" height="250p"></canvas>

          <div class=" bg-white progress_summary">

          </div>
        </div>
      </div>
    </div> -->
    <div class="col-md-6 col-sm-6 ">
      <div class="x_panel tile fixed_height_320">
        <div class="x_title">
          <h2>Today Cashouts <small>Contributions</small></h2>
          <ul class="nav navbar-right panel_toolbox">
            
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table class="" style="width:100%">
            <tr>
              <th style="width:37%;">
                <p>Contribution</p>
              </th>
              <th>
                <div class="col-lg-7 col-md-7 col-sm-7 ">
                  <p class="">Employer</p>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 ">
                  <p class="">Percentage</p>
                </div>
              </th>
            </tr>
            <tr>
              <td>
              <canvas id="myDoughnutChartcashout" class="myDoughnutChartcashout" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
              </td>
              <td>

              <?php 

$sql_single_day_total_cashout="SELECT SUM(Amountcashout) AS OverallTotalcahout FROM tbl_cashout WHERE DATE(Addeddate) = CURDATE()";
$db = dbConn();
$result_single_day_total_cashout = $db->query($sql_single_day_total_cashout);
$row_single_day_totalsale = $result_single_day_total_cashout->fetch_assoc();
 $today_cashout_sum = $row_single_day_totalsale['OverallTotalcahout'];

 
        $sql_single_cashout_emp="SELECT Cashoutuserid, SUM(Amountcashout) AS TotalAmountCashout,EmpFName,EmpLName 
        FROM tbl_cashout 
        inner JOIN tbl_emp on tbl_cashout.Cashoutuserid = tbl_emp.EmpId 
        WHERE DATE(Addeddate) = CURDATE() GROUP BY Cashoutuserid";
        $db = dbConn();
        $result_single_cashout_emp= $db->query($sql_single_cashout_emp);

       
       
        ?>


                <table class="tile_info">
                <?php
 if ($result_single_cashout_emp->num_rows > 0) {
 while ($row_single_cashout_emp = $result_single_cashout_emp->fetch_assoc()) {
 ?>
                  <tr>
                    <td>
                    <p><i class="fa fa-square color-icon"></i> <?= ucwords( $row_single_cashout_emp['EmpFName']) . " " . ucwords($row_single_cashout_emp['EmpLName'] )?> </p>
                    </td>
                    <td><?php $emp_today_cashout = $row_single_cashout_emp['TotalAmountCashout'];
                   echo number_format(( $emp_today_cashout /$today_cashout_sum )*100) ;
                    
                    ?>%</td>
                  </tr>
                  <?php }}?>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
<!-- end  -->

    <!-- start -->
    <div class="col-md-6 col-sm-6 ">
      <div class="x_panel tile fixed_height_320">
        <div class="x_title">
          <h2>Loss And Profit <small>Contributions</small></h2>
          <ul class="nav navbar-right panel_toolbox">
            
          </ul>
          <canvas id="profitandloss" aria-label="chart" ></canvas>
          <div class="clearfix">
            
          </div>
        </div>
        <div class="x_content">
       
        </div>
      </div>
    </div>
    <!-- end -->

  </div>
</div>
</div>

<?php 
//        SELECT op.productid, imi.productid, tp.ProductID , tp.ProductCategory , imi.price FROM `orderproducts` op INNER JOIN tbl_imie imi on op.productid= imi.productid INNER JOIN tbl_products tp on op.productid=tp.ProductID;
        //$sqldiscount = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleAmount) AS total_sale FROM tbl_sales WHERE SaleDate >= CURDATE() - INTERVAL 6 DAY GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
        
        $sqldiscount=" SELECT date_range.date AS sale_day, COALESCE(SUM(s.SaleAmount), 0) AS total_sale
        FROM (
            SELECT CURDATE() - INTERVAL n DAY AS date
            FROM (
                SELECT @row := @row - 1 AS n
                FROM information_schema.columns, (SELECT @row := 13) r
                LIMIT 14
            ) dates
        ) date_range
        LEFT JOIN tbl_sales s ON date_range.date = DATE(s.SaleDate)
        GROUP BY date_range.date
        ORDER BY date_range.date DESC;
        ";
        $db = dbConn();
        $resultdiscount = $db->query($sqldiscount);

        $data_labeldiscount = array();
        $data_valuediscount = array();

        while ($rowdiscount = $resultdiscount->fetch_assoc()) {
            $data_labeldiscount[] = $rowdiscount['total_sale'];
            $data_valuediscount[] = $rowdiscount['sale_day'];
        }
         "<br>";
         "'" . implode("','", $data_valuediscount) . "'";
         implode(",", $data_labeldiscount);
        ?>

<!-- start php generating for stylist sales pie chart -->
<?php 
 
        $sql_single_sale="SELECT 
        EmplyoeeID, 
        SUM(SaleServiceSale) AS TotalSales , EmpFName,EmpLName
    FROM 
        tbl_sales_services LEFT JOIN tbl_emp on tbl_sales_services.EmplyoeeID = tbl_emp.EmpId
    WHERE 
        DATE(SaleServiceAddedDate) = CURDATE() 
    GROUP BY 
        EmplyoeeID";
        $db = dbConn();
        $result_single_sale = $db->query($sql_single_sale);

        $data_label_single_sale = array();
        $data_value_single_sale = array();

        while ($row_single_sale = $result_single_sale->fetch_assoc()) {
            $data_label_single_sale[] = $row_single_sale['TotalSales'];
            $data_value_single_sale[] = ucwords($row_single_sale['EmpFName']) . " ". ucwords($row_single_sale['EmpLName']);
        }
         "<br>";
         "'" . implode("','", $data_value_single_sale) . "'";
         implode(",", $data_label_single_sale);
        ?>
<!-- end php generating for stylist sales pie chart -->


<!-- start php generating for stylist cashout pie chart -->
<?php 
 
        $sql_single_cashout="SELECT Cashoutuserid, SUM(Amountcashout) AS TotalAmountCashout,EmpFName,EmpLName 
        FROM tbl_cashout 
        inner JOIN tbl_emp on tbl_cashout.Cashoutuserid = tbl_emp.EmpId 
        WHERE DATE(Addeddate) = CURDATE() GROUP BY Cashoutuserid";
        $db = dbConn();
        $result_single_cashout= $db->query($sql_single_cashout);

        $data_label_single_cashout = array();
        $data_value_single_cashout = array();

        while ($row_single_cashout = $result_single_cashout->fetch_assoc()) {
            $data_label_single_cashout[] = $row_single_cashout['TotalAmountCashout'];
            $data_value_single_cashout[] = ucwords($row_single_cashout['EmpFName']) . " ". ucwords($row_single_cashout['EmpLName']);
        }
         "<br>";
         "'" . implode("','", $data_value_single_cashout) . "'";
         implode(",", $data_label_single_cashout);
        ?>
<!-- end php generating for stylist cashout pie chart -->



<!-- /page content -->


<!-- start the coloring doughnut chart of current date services -->
<script>
            document.addEventListener("DOMContentLoaded", function () {
                // Your color array
                var colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#81C784', '#FFD700', '#8B4513', '#7B68EE'];
                
                // Get all elements with class "color-icon"
                var icons = document.querySelectorAll('.color-icon');
                
                // Loop through the icons and assign colors
                for (var i = 0; i < icons.length; i++) {
                    icons[i].style.color = colors[i];
                }
            });
        </script>
<!-- start the coloring doughnut chart of current date services -->

<script>
  const ctx20 = document.getElementById('myChart20');
  new Chart(ctx20, {
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


<!-- start of Stylist daily sale doughnutchart -->
<script>
  // Sample data for the doughnut chart
  var data = {
    labels: [],
    datasets: [{
      data: [<?= implode(",", $data_label_single_sale) ?>], // Values for each segment
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#81C784', '#FFD700', '#8B4513', '#7B68EE'], // Colors for each segment
      hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#81C784', '#FFD700', '#8B4513', '#7B68EE'] // Hover colors for each segment
    }],
    options: {
      legend: {
        display: false // Hide the legend
      },
      tooltips: {
        enabled: false // Disable tooltips
      }
    }
  };

  // Get the canvas element
  var ctx3 = document.getElementById('myDoughnutChart').getContext('2d');

  // Create the doughnut chart
  var myDoughnutChart = new Chart(ctx3, {
    type: 'doughnut',
    data: data
  });
</script>
<!-- end of Stylist daily sale doughnutchart -->

<!-- start current day each service count  -->
<?php 
   $sql_current_date_services="SELECT ServicesIDSales, COUNT(ServicesIDSales) AS ServiceCount, ServiceName 
   FROM tbl_sales_services left join tbl_services on tbl_sales_services.ServicesIDSales = tbl_services.ServicesID 
   WHERE DATE(SaleServiceAddedDate) = CURDATE() GROUP BY ServicesIDSales";
   $db = dbConn();
   $result_current_date_services= $db->query($sql_current_date_services);

   $data_label_current_date_services = array();
   $data_value_current_date_services = array();

   while ($row_current_date_services = $result_current_date_services->fetch_assoc()) {
       $data_label_current_date_services[] = $row_current_date_services['ServiceCount'];
       $data_value_current_date_services[] = $row_current_date_services['ServiceName'];
   }

   $new_array = array();

   // Assuming both arrays have the same length
   $length = count($data_label_current_date_services);
   
   for ($i = 0; $i < $length; $i++) {
       // Combine corresponding elements from both arrays as a flat pair
       $new_array[] = "['" . $data_value_current_date_services[$i] . "', " . $data_label_current_date_services[$i] . "]";
   }
   
   // Output the new array
    '<br>';
    implode(',', $new_array);
   

  //  echo "<br>";
  //  echo "'" . implode("','", $data_value_current_date_services) . "'";
  //  echo implode(",", $data_label_current_date_services);

?>
<!-- end current day each service count  -->
<script type="text/javascript">
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawRightY);

    function drawRightY() {
        var data = google.visualization.arrayToDataTable([
            ['', ''],
            <?= implode(',', $new_array); ?>
        ]);

        var materialOptions = {
            chart: {
                title: '',
            },
            hAxis: {
                title: 'Total Session Count',
                minValue: 0,
            },
            vAxis: {
                title: ''
            },
            bars: 'horizontal',
            axes: {
                y: {
                    0: {side: 'right'}
                }
            },
            colors: ['#1ABB9C', '#DC3912', '#FF9900'] // Specify your desired colors here
        };

        var materialChart = new google.charts.Bar(document.getElementById('chart_div'));
        materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
    }
</script>

<!-- start of Stylist daily cashout doughnutchart -->
<script>
  // Sample data for the doughnut chart
  var data = {
    labels: [],
    datasets: [{
      data: [<?= implode(",", $data_label_single_cashout) ?>], // Values for each segment
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#81C784', '#FFD700', '#8B4513', '#7B68EE'], // Colors for each segment
      hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#81C784', '#FFD700', '#8B4513', '#7B68EE'] // Hover colors for each segment
    }],
    options: {
      legend: {
        display: false // Hide the legend
      },
      tooltips: {
        enabled: false // Disable tooltips
      }
    }
  };

  // Get the canvas element
  var ctx333 = document.getElementById('myDoughnutChartcashout').getContext('2d');

  // Create the doughnut chart
  var myDoughnutChart = new Chart(ctx333, {
    type: 'doughnut',
    data: data
  });




  <?php 

 // Check if the form is submitted

     // Get the start and end dates from the form
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


?>
  
</script>
<!-- end of Stylist daily cashout doughnutchart -->




<script>
  const ctx22 = document.getElementById('profitandloss');
  new Chart(ctx22, {
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
      },legend: {
        display: false // Hide the legend
      }
    }
  });


</script>

<?php

include 'footer.php'

  ?>